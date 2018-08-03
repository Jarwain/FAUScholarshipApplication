<?php
namespace ScholarshipApi\View;

class ScholarshipView {
	static function list($view, $scholarships){
        $body = new ViewPart('admin/scholarship_list.phtml');
        $body->addAttribute('scholarships', $scholarships);

        $view->addPart('body', $body);
		return $view;
	}

	static function item($view, $scholarship, $test = null){
		$body = new ViewPart('admin/scholarship_item.phtml');
		$body->addAttribute('scholarship', $scholarship);
		$body->addAttribute('test', $test);
		
		$view->addPart('body', $body);
		return $view;
	}

	static function edit($view, $scholarship, $questions, $qualifiers){
		$body = new ViewPart('admin/scholarship_editor.phtml');
        $body->addScript('vue.js');
        $body->addScript('admin/scholarship_editor.js');
		$body->addAttribute('scholarship', $scholarship);
		$body->addScriptVar('scholarship', $scholarship);
        $body->addAttribute('questions', $questions);
        $body->addScriptVar('questions', $questions);
        $body->addAttribute('qualifiers', $qualifiers);
        $body->addScriptVar('qualifiers', $qualifiers);

        $view->addPart('body', $body);
        return $view;
	}

	static function create($view, $questions, $qualifiers){
		$body = new ViewPart('admin/scholarship_editor.phtml');
        $body->addScript('vue.js');
        $body->addScript('admin/scholarship_editor.js');
        $body->addAttribute('questions', $questions);
        $body->addAttribute('qualifiers', $qualifiers);

        $view->addPart('body', $body);
        return $view;
	}
}