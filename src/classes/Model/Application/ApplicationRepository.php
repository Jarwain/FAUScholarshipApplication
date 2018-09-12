<?php
namespace ScholarshipApi\Model\Application;

use ScholarshipApi\Model\AbstractRepository;

class ApplicationRepository extends AbstractRepository implements ApplicationStore{

	function getByZnumber($znumber) {
		return $this->getStore()->getByZnumber($znumber);
	}
}
