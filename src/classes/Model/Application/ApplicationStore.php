<?php
namespace ScholarshipApi\Model\Application;

use ScholarshipApi\Model\AbstractStore;

interface ApplicationStore extends AbstractStore{

	function getByZnumber($znumber);
}
