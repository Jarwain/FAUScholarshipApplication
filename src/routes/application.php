<?php

$this->group('/applications', function() {

	// Get Random Application. If Code, get all applications for given code
	$this->get('/[{code}/]', function($request, $response, $args){
		// Check for code to determine which scholarships to return
		
		if($args['code'] !== null && !Scholarship::exists($args['code'])){
			throw new genException($args['code'] . " does not exist.");
		}
		
		$result1 = $database->getScholarshipFromDB($args['code']);
		$result2 = $database->getScholarshipsAndQuestionsFromDB($args['code']);
		
		// TODO: Decide on which implementation to use...
		return $response->withJson([$result1,$result2]);
	});
	//$this->get('/student/')
	$this->post('/', function($request, $response){
		$scholarship = new Scholarship($request->getParsedBody());
		if(!$scholarship->saveScholarship()){
			throw new genException("Scholarship Post/Save failed?");
		}

		return $response->withJson(messageResponse(true,$scholarship->code . " added successfully",["scholarship"=>Scholarship::getScholarshipFromDB($scholarship->code)]));

		// TODO: Append copy of scholarship in "get" form.

	});

	$this->delete('/{code}/', function($request, $response, $args){
		if(!Scholarship::deleteScholarshipFromDB($args['code'])){
			throw new genException("Scholarship Delete failed?");
		}
		return $response->withJson(messageResponse(true,$args['code']." successfully deleted.".$result));
		
	});
});

/*

Get random Application
	/applications/ 						GET
Get all applications for code
	/applications/?code 				GET
Get all applications for student
	/applications/student/?znumber 		GET
Get all applications for student with given first/last name
	/applications/student/?first&last 	GET
Submit Application
	/applications/						POST
Decide on Application
	/applications/						PUT

GET
Returns (if no params, random)(if znumber||(first&&last), all with znumber)(if code, all with code)(if combo, all with combo)
	{ 
		"znumber":"",
		"code":"",
		"accepted":#,
		"ranking":#,
		"note":"",
		"answers":
			[{
				"question_id":#,
				"type":#,
				"question":"",
				"response":"",
				"summary":""
			},]
	}
POST
	Parameters
		{ 
			"znumber":"",
			"code":"",
			"answers":
				[{
					"question_id":#,
					"response":"",
					"summary":""
				},]
		}
	Returns
		{
			"status":true/false,
			"message":"",
			"id":#
		}
*/