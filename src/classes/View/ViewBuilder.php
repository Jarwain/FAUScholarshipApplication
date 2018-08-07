<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class ViewBuilder {
	protected $layout;
	protected $parts;

	public function __construct($layout){
		$this->layout = $layout;
	}

	function getLayout(){
		return $this->layout;
	}

	function addPart($name, ViewPart $part){
		$this->parts[$name] = $part;
	}

	function getPart($name){
		return $this->parts[$name];
	}

	function getData(){
		$data = [];
		$styles = [];
		$scripts = [];
		foreach($this->parts as $name=>$part){
			$data['part'][$name] = $part;
			$styles = array_merge($styles, $part->getStyles());
			$scripts = array_merge($scripts, $part->getScripts());
		}
		$data['styles'] = $styles;
		$data['scripts'] = $scripts;
		return $data;
	}

	function render($renderer, $response){
		return $renderer->render($response, $this->getLayout(), $this->getData());
	}
}