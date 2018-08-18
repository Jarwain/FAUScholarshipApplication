<?php
namespace ScholarshipApi\Model\File;

class File {
	var $id;
	var $name;
	var $md5;
	var $data;
	var $size;
	var $created;

	function __construct($id = Null, $name, $md5, $data, $size, $created = Null){

	}
}
