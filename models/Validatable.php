<?php
class ValidationException extends Exception {
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

trait ValidateBoolean {
	function validate($value, $param = ['true','false']){
		if(in_array($value, $param))
			return true;	
		
		throw new ValidationException("[Boolean]: $value not in json_encode($param)");
		
	}
}

trait ValidateRange {
	function validate($value, $param){
		if($param[0] <= $value && $value <= $param[1])
			return true;

		throw new ValidationException("[Range]: $value not between json_encode($param)");
	}
}

trait ValidateSingle {
	function validate($value, $param){
		if(in_array($value, $param))
			return true;

		throw new ValidationException("[Single]: $value not in json_encode($param)");
	}
}

trait ValidateMulti {
	function validate($value, $param){
		return true;
	}
}

?>