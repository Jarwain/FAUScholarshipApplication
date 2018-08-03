<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class ViewPart {
	protected $template;
	protected $styles;
	protected $attr;
	protected $scripts;
	protected $scriptVar = [];

	public function __construct(string $template, array $attr = null, array $styles = null, array $scripts = null){
		$this->template = $template;
		$this->attr = $attr ?? [];
		$this->styles = $styles ?? [];
		$this->scripts = $scripts ?? [];
	}

	function addStyle(string $style){
		$this->styles[] = $style;
		return $this;
	}

	function addAttribute(string $key, $val){
		$this->attr[$key] = $val;
		return $this;
	}

	function addAttributes(array $arr){
		foreach($arr as $key => $val){
			$this->addAttribute($key, $val);
		}
		return $this;
	}

	function addScriptVar(string $key, $val){
		$this->scriptVar[$key] = $val;
		return $this;
	}

	function getScriptVar(){
		return $this->scriptVar;
	}

	function addScript(string $script){
		$this->scripts[] = $script;
		return $this;
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