<?php
namespace ScholarshipApi\Util;

class ValidationException extends \Exception{
	private $parts;

	public function __construct($message, $parts = [], $code = 0, Exception $previous = null){
		parent::__construct($message, $code, $previous);
		$this->parts = $parts;
	}

	public function getParts() {
		return $this->parts;
	}
}
