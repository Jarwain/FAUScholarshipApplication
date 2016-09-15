<?php

class Question {
	public $id;
	public $type;
	public $question;
	public $settings;

	function __construct(array $row){
		$this->id = $row['id'];
		$this->type = $row['type'];
		$this->question = $row['question'];
		$this->settings = json_decode($row['settings']);
	}
}