<?php

class Scholarship{
	public $code;
	public $name;
	public $description;
	public $active;
	public $counter;
	public $bound;
	public $question;

	function __construct(array $row){
		$this->code = $row['code'];
		$this->name = $row['name'];
		$this->description = $row['description'];
		$this->active = $row['active'];
		$this->counter = 0;
		$this->bound = $row['bound'];
		$this->question = empty($row['question']) ? [] : $row['question'];
	}
}