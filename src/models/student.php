<?php

class Student {
	public $znumber;
	public $name;
	public $email;
	public $qualifications;

	function __construct(array $row){
		$this->znumber = $row['znumber'];
		$this->name = $row['name'];
		$this->email = $row['email'];
	}
}