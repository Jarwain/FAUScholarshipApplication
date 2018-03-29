<?php
namespace Validate;

class Result {
	var $res; // Boolean
	var $message; // String
	public function __construct($res, $message = "") {
        $this->res = $res;
        $this->message = $message;
    }
}

trait Boolean { // type: 1
	function validate($value, $param = NULL){
		if(is_null($param)) $param = ['true','false'];

		if(in_array($value, $param))
			return new Result(true);

		return new Result(false, "[Boolean]: $value not in ".json_encode($param));
	}
}

trait Range { // type: 2
	function validate($value, $param){
		if($param[0] <= $value && $value <= $param[1])
			return new Result(true);

		return new Result(false, "[Range]: ".json_encode($value)." not between ".json_encode($param));
	}
}

trait Single { // type: 3
	function validate($value, $param){
		if(in_array($value, $param) || (count($param) === 1 && $param[0] === '*'))
			return new Result(true);

		return new Result(false, "[Single]: ".json_encode($value)." not in ".json_encode($param));
	}
}

trait Multi { // type: 4
	function validate($value, $param){
        if(count(array_intersect($value, $param)) !== 0)
		  return new Result(true);

        return new Result(false, "[Multi]: ".json_encode($value)." not in ".json_encode($param));
	}
}

?>