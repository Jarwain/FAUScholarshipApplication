<?php
namespace ScholarshipApi\Util;

class DataBuilder{
    protected $attr;
    protected $style;
    protected $parts;
    protected $script;

    function __construct(array $attr = [], array $style = [], array $parts = [], array $scripts = []){
        $this->attr = $attr;
        $this->style = $style;
        $this->parts = $parts;
        $this->script = $scripts;
    }

    function addAttribute($name, $value){
        $this->attr[$name] = $value;
    }
    function addAttr($name, $value){
        $this->addAttribute($name, $value);
    }

    // $baseUrl."/css/".$styleName
    // Style files should be in /public/css/
    // $name should NOT have a leading slash Ex: "sticky_footer.css" 
    function addStyle($name){
        $this->style[] = $name;
    }
    function addScript($name){
        $this->script[] = $name;
    }

    function addPart($name, $template, $data = [], $styles = [], $scripts = []){
        $this->parts[$name]['template'] = $template;
        $this->parts[$name]['data'] = $data;
    }

    function getData(){
        $data = $this->attr;
        $data['styles'] = $this->style;
        $data['scripts'] = $this->script;
        foreach ($this->parts as $name => $part) {
            $part['data'] = array_merge($this->attr, $part['data']);
            $data['part'][$name] = $part;
        }
        return $data;
    }

}