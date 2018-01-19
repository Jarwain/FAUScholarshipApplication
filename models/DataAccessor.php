<?php
	class DataAccessor { 

		// TODO: 
		// Turn into abstract class/interface
		// Individualize by model (StudentDAO, ScholarshipDAO, etc.)
		// Create memoization store

		var $link;

		function __construct(){
			$settings = json_decode(file_get_contents(__DIR__ . "/../.config/database"));
			$this->link = new \PDO( 'mysql:host='.$settings->host.';dbname='.$settings->dbname.';charset=utf8mb4',
				$settings->user,
				$settings->pass,
				array(
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_PERSISTENT => false
				)
			);
		}

		function getScholarshipsJoinRestriction(){
			try{
				$restrictions = $this->link->query("SELECT * FROM `scholarship` s 
				LEFT JOIN `restriction` r ON s.`code` = r.`sch_code`")->fetchAll();

				$scholarships = array_reduce($restrictions,function($carry, $val){
					if(array_key_exists($val['code'],$carry)){
						// Add Restriction to existing Scholarship inst
						$carry[$val['code']]->restrictions[$val['category']][$val['qualifier_id']] = Restriction::array_to_restriction($val);
					} else {
						// Instantiate Scholarship 
						$carry[$val['code']] = Scholarship::array_to_scholarship($val);
						if($val['qualifier_id'])
							$carry[$val['code']]->restrictions[$val['category']][$val['qualifier_id']] = Restriction::array_to_restriction($val);
						else $carry[$val['code']]->restrictions = null;
					}
					return $carry;
				},array());
				return new ArrayOfScholarships($scholarships);
			} catch (Exception $ex){
				throw $ex;
			}
		}

		function getAllQualifiers(){
			try{
				$dbQualifiers = $this->link->query("SELECT `id`,`name`,`type`,`question`,`param` FROM `qualifier`")->fetchAll();

				return new ArrayOfQualifiers(array_map('QualifierFactory::array_to_object', $dbQualifiers));
			} catch (Exception $ex){
				throw $ex;
			}
		}

		function getActiveQualifiers(){
			try{
				$dbQualifiers = $this->link->query("SELECT q.`id`, q.`name`, q.`type`, q.`question`, q.`param` FROM `qualifier` q 
					JOIN `restriction` r ON q.`id`=r.`qualifier_id`
					GROUP BY `qualifier_id`")->fetchAll();

				return new ArrayOfQualifiers(array_map('QualifierFactory::array_to_object', $dbQualifiers));
			} catch (Exception $ex){
				throw $ex;
			}
		}
	}
?>