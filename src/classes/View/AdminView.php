<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class AdminView {
	const ACTIVE_SCHOLARSHIPS = 'scholarships';
	const ACTIVE_QUESTIONS = 'questions';
	const ACTIVE_QUALIFIERS = 'qualifiers';

	static function navbar($view, $active){
		$navbar = new ViewPart('admin/navbar.phtml');
		$navbar->addAttribute('active', $active);
		$view->addPart('navbar', $navbar);
		return $view;
	}
}