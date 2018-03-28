<?php
require_once('Scholarship.php');
require_once('Qualifier.php');
class ScholarshipController {
    var $path;
    var $scholarships;

    function __construct($path, $db){
        $this->path = $path;

        $jsonSCH = json_decode(file_get_contents($path), true);
        if($jsonSCH === FALSE) {
            throw new Exception('JSON NOT READ');
        }

        $restrictions = $db->query("SELECT s.code, s.name, s.description, s.active, s.counter, s.limit, r.category, r.valid, q.id as qualifier_id, q.question, q.name as q_name, q.type, q.param FROM `scholarship` s
            LEFT JOIN `restriction` r ON s.`code` = r.`sch_code`
            LEFT JOIN `qualifier` q ON q.`id` = r.`qualifier_id`")->fetchAll();

        $this->scholarships = array_reduce($restrictions, function($carry, $val){
            if(!array_key_exists($val['code'], $carry)){
                // Instantiate Scholarship
                if($val['qualifier_id']){
                    $req = new Requirement((int)$val['qualifier_id'], $val['q_name'], $val['question'], json_decode($val['param'], true), $val['category'], json_decode($val['valid'],true));
                    $requirement = [ $req->group => [ $req->id => $req ] ];
                }
                else $requirement = [];

                $sch = new ApplicationScholarship($val['code'], (boolean)$val['active'], 1, $val['name'], $val['description'], (int)$val['counter'], (int)$val['limit'], $requirement);
                $carry[$val['code']] = $sch;
            } else {
                // Add Requirement to existing Scholarship inst
                $req = new Requirement((int)$val['qualifier_id'], $val['q_name'], $val['question'], json_decode($val['param'], true), $val['category'], json_decode($val['valid'],true));
                $carry[$val['code']]->requirements[$req->group][$req->id] = $req;
            }
            return $carry;
        }, []);
        $db = array_keys($this->scholarships);
        $js = array_reduce($jsonSCH, function($a,$e){
            $a[] = $e['id'];
            return $a;
        },[]);
        //$this->scholarships = ['db' => $db, 'js' => $js];
        foreach ($jsonSCH as $sch){
            if(isset($this->scholarships[$sch['id']])){
                if($this->scholarships[$sch['id']]->description !== $sch['description']){
                    $description['db'] = $this->scholarships[$sch['id']]->description;
                    $description['js'] = $sch['description'];
                    $this->scholarships[$sch['id']]->description = $description;
                }
                if($this->scholarships[$sch['id']]->name !== $sch['name']){
                    $name['db'] = $this->scholarships[$sch['id']]->name;
                    $name['js'] = $sch['name'];
                    $this->scholarships[$sch['id']]->name = $name;
                }
            } else {
                $this->scholarships[$sch['id']] = Scholarship::FactoryArray($sch);
            }
        }
        /*$this->scholarships = array_reduce($jsonSCH, function($a, $e){
            $a[$e['id']] = Scholarship::FactoryArray($e);
            return $a;
        }, []);*/
     }

    function getScholarships(){
        return $this->scholarships;
    }

    function getSite(){
        return array_values($this->scholarships);
    }

    /*function saveJson(){
        $json = $this->getScholarships(true);
        $res = file_put_contents(__DIR__."/../../assets/scholarship.json", json_encode($json));
        if($res === false)
            throw Exception('Scholarship Save Failed');
    }

    function addExternal($sch){
        if(!isset($sch['id']) || array_key_exists($sch['id'], $this->scholarships)){
            $external = array_filter($this->scholarships, function($e){
                return $e->category === 3;
            });
            $last = array_pop($external);
            $num = (int)substr($last->id, 3);
            $newNum = $num + 1;
            // Cause ScholarshipIDs have a db_defined limit of 6 characters atm.
            if($newNum >= 1000)
                $pre = "EX";
            else if($newNum >= 10000)
                $pre = "E";
            else
                $pre = "EXT";
            $sch['id'] = $pre.$newNum;
        }

        $this->scholarships[$sch['id']] = Scholarship::FactoryArray($sch);

        $this->saveJson();
    }

    function addScholarship($sch){
        switch($sch['category']){
            case 1:

                break;
            case 2:

                break;
            case 3:
                $this->addExternal($sch);
                break;
            default:
                throw new Exception('No category given');
        }
        return true;
    }*/

}