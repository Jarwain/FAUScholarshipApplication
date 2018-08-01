<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class ViewPart {
	protected $template;
	protected $styles;
	protected $attr;
	protected $scripts;

	public function __construct(string $template, array $attr = null, array $styles = null, array $scripts = null){
		$this->template = $template;
		$this->attr = $attr ?? [];
		$this->styles = $styles ?? [];
		$this->scripts = $scripts ?? [];
	}

	function addStyle(string $style){
		$this->styles[] = $style;
	}

	function addAttribute(string $key, $val){
		$this->attr[$key] = $val;
	}

	function addAttributes(array $arr){
		foreach($arr as $key => $val){
			$this->addAttribute($key, $val);
		}
	}

	function addScript(string $script){
		$this->scripts[] = $script;
	}

	function getTemplate(){
		return $this->template;
	}

	function getAttributes(){
		return $this->attr;
	}

	function getData(){
		return $this->getAttributes();
	}

	function getStyles(){
		return $this->styles;
	}

	function getScripts(){
		return $this->scripts;
	}
}