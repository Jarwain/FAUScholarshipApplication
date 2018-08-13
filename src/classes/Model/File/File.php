<?php
namespace ScholarshipApi\Model\File;

class File {
	var $id;
	var $name;
	var $md5;
	var $data;
	var $size;
	var $created;
	var $znumber;

	function __construct($id = Null, $znumber, $name, $md5, $data, $size, $created = Null){

	}
}
