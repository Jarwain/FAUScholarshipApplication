<?php

class ScholarshipController {
    var $path;

    var $scholarships;

    function __construct($path){
        $this->path = $path;

        $jsonSCH = json_decode(file_get_contents($path));
        if($jsonSCH === FALSE) {
            throw Exception('JSON NOT READ');
        }

        $this->scholarships = array_reduce($jsonSCH, function($a, $e){
            $a[$e->id] = new Scholarship($e->id, $e->active, $e->category_ref, $e->name, $e->description, $e->url, $e->deadline);
            return $a;
        }, []);
     }

    function getScholarships($values = false){
        if($values) 
            return array_values($this->scholarships);
        else 
            return $this->scholarships;
    }

    function getSite(){
        return array_values($this->scholarships);
    }

    function addScholarship($sch){
        switch($e->category_ref){
            case 1: 

                break;
            case 3:
                addExternal($sch);
                break;
            default:
                throw Exception('No category given');
        }
        return true;
    }

    function addExternal($sch){
        if(!isset($sch->id) || array_key_exists($sch->id, $this->scholarships)){
            $external = array_filter($this->scholarships, function($e){
                return $e->category === 3;
            });
            $last = array_pop($external);
            $num = (int)substr($last->id, 3);
            $sch->id = "EXT".($num+1);
        }
        $this->scholarships[$sch->id] = Scholarship::FactoryArray($sch);
        
        saveJson();
    }

    function saveJson(){
        $json = $this->getScholarships(true);
        $res = file_put_contents(__DIR__."/../../assets/scholarship1.json", json_encode($json));
        if($res === false)
            throw Exception('Scholarship Save Failed');
    }
}