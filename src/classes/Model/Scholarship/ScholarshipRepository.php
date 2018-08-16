<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\AbstractRepository;

class ScholarshipRepository extends AbstractRepository implements ScholarshipStore{
	function getActive(){
		return array_filter($this->getAll(), function($e) {
			return $e->active;
		});
	}
}
