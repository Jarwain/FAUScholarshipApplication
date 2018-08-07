<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class ApplicationView {
	static function navbar($view){
		$navbar = new ViewPart('application/navbar.phtml');
		
		$view->addPart('navbar', $navbar);
		return $view;
	}

	static function studentForm($view, $qualifiers){
		$studentForm = new ViewPart('application/student_info.phtml');
		$studentForm->addAttribute('qualifiers', $qualifiers);
		$studentForm->addScript('vue.js');
        $studentForm->addScript('vue/vue.umd.min.js');
        $studentForm->addScript('student_editor.js');

		$view->addPart('studentForm', $studentForm);
		return $view;
	}
}