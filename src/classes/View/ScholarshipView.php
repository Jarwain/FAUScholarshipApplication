<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class ScholarshipView {
	static function list($renderer, Response $response, $data){
		$view = new ViewBuilder($renderer, $response);
		$view->setLayout('admin/admin_layout.phtml');

		$body = new ViewPart('admin/login.phtml');
		$body->addAttributes($data);

		$view->addPart('body', $body);

		return $view->render();
	}

	static function item($renderer, Response $response){
		
	}

	static function edit($renderer, Response $response){
	}
}