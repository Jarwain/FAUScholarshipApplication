<?php
namespace ScholarshipApi\Model;

trait OptionTrait {
    public $options = [];
    public $requiredOptions = [];

    function getOptions(){
        return $this->options;
    }

    function getOption($o){
        $res = $this->options[$o];
        if(array_key_exists($o, $this->getOptions())){
            return $this->options[$o];
        } else {
            return Null;
        }
    }

    function checkRequiredOptions(){
        foreach($this->requiredOptions as $r){
            if(is_null($this->getOption($r))){
                throw new \DomainException("{get_class($this)} requires option '{$r}'");
            }
        }
    }
}