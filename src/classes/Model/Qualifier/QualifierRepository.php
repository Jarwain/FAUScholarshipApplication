<?php
namespace ScholarshipApi\Model\Qualifier;

use ScholarshipApi\Model\AbstractRepository;

class QualifierRepository extends AbstractRepository implements QualifierStore{
	function getAllByName(){
		$res = [];
		$qualifiers = $this->getAll();
		foreach($qualifiers as $q){
			$res[$q->getName()] = $q;
		}
		return $res;
	}
}