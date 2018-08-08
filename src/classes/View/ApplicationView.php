<?php
namespace ScholarshipApi\View;

use Slim\Http\Response;

class ApplicationView {
	static function navbar($view){
		$navbar = new ViewPart('application/navbar.phtml');
		
		$view->addPart('navbar', $navbar);
		return $view;
	}

	static function studentForm($view, $qualifiers, $student = null){
		$studentForm = new ViewPart('application/student_info.phtml');
		$studentForm->addAttribute('qualifiers', $qualifiers);
		$studentForm->addAttribute('student', $student);
		$studentForm->addScript('vue.js');
        $studentForm->addScript('components/qualifier_inputs.js');
        $studentForm->addScript('student_editor.js');

		$view->addPart('studentForm', $studentForm);
		return $view;
	}

	static function scholarshipSelect($view, $qualifiers){
		$studentForm = new ViewPart('application/student_info.phtml');
		$studentForm->addAttribute('qualifiers', $qualifiers);
		$studentForm->addScript('vue.js');
        $studentForm->addScript('components/scholarship_select.js');
        $studentForm->addScript('student_editor.js');

		$view->addPart('studentForm', $studentForm);
		return $view;
	}
}