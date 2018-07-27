<?php
namespace ScholarshipApi\Model;

trait PropTrait {
    public $props = [];

    function setProps($props){
        if(!is_null($props)){
            $this->props = array_merge($this->props, $props);
        }
    }
    function getProps(){
        return $this->props;
    }

    function getProp($o){
        $res = $this->props[$o];
        if(array_key_exists($o, $this->getProps())){
            return $this->props[$o];
        } else {
            return Null;
        }
    }

    function getPossibleProps(){
        return [
            "required" => $this->requiredProps,
            "optional" => $this->optionalProps
        ];
    }

    protected function setOptionalProps($props){
        if(!is_null($props)){
            $this->optionalProps = array_unique(array_merge($this->optionalProps, $props), SORT_REGULAR);
        }
    }

    protected function setRequiredProps($props){
        if(!is_null($props)){
            $this->requiredProps = array_unique(array_merge($this->requiredProps, $props), SORT_REGULAR);
        }
    }

    function checkRequiredProps(){
        foreach($this->requiredProps as $r){
            if(is_null($this->getProp($r))){
                throw new \DomainException("{get_class($this)} requires prop '{$r}'");
            }
        }
    }
}