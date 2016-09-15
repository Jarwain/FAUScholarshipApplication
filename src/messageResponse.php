<?php
function messageResponse($status,$message, $arr = null){
	$ret = ["status"=>$status,"message"=>$message];
	if(null !== $arr){
		$ret = array_merge($ret,$arr);
	}
	return $ret;
}
?>