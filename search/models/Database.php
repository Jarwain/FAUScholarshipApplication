<?php
	class Database{
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
			return $dbRestrictions = $this->link->query("SELECT * FROM `scholarship` s 
				LEFT JOIN `restriction` r ON s.`code` = r.`sch_code` 
				WHERE s.`code` like 'TST%'")->fetchAll(PDO::FETCH_CLASS,"Scholarship");
		}


	}
?>