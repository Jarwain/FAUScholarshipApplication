<?php
namespace ScholarshipApi\Model\Scholarship;

use ScholarshipApi\Model\AbstractRepository;

class ScholarshipRepository extends AbstractRepository implements ScholarshipStore{
	function getApplicable(){
		return array_filter($this->getAll(), function($e) {
			return $e->isApplicable();
		});
	}
}
