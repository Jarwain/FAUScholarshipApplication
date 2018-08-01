<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class AuthView {
	static function login($renderer, Response $response, $data){
		$view = new ViewBuilder($renderer, $response);
		$view->setLayout('admin/admin_layout.phtml');

		$body = new ViewPart('admin/login.phtml');
		$body->addAttributes($data);

		$view->addPart('body', $body);

		return $view->render();
	}

	static function logout($renderer, Response $response){
		$view = new ViewBuilder($renderer, $response);
		$view->setLayout('admin/admin_layout.phtml');
		$view->addPart('body', new ViewPart('admin/logout.phtml'));

		return $view->render();
	}
}