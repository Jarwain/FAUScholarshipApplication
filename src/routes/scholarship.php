<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

$this->group('/scholarships', function() {

	$this->get('/[{code}/]', function($request, $response, $args){
		// Check for code to determine which scholarships to return
		
		if(array_key_exists('code',$args) || !Scholarship::exists($args['code'])){
			throw new genException($args['code'] . " does not exist.");
		}
		
		$result1 = Scholarship::getScholarshipFromDB($args['code']);
		$result2 = Scholarship::getScholarshipsAndQuestionsFromDB($args['code']);
		
		// TODO: Decide on which implementation to use...
		return $response->withJson([$result1,$result2]);
	});

	$this->post('/', function($request, $response){
		$scholarship = new Scholarship($request->getParsedBody());
		if(!$scholarship->saveScholarship()){
			throw new genException("Scholarship Post/Save failed?");
		}

		return $response->withJson(
			messageResponse(true, 
							$scholarship->code . " added successfully",
							["scholarship"=>Scholarship::getScholarshipFromDB($scholarship->code)]
							));
	});

	$this->delete('/{code}/', function($request, $response, $args){
		if(!Scholarship::deleteScholarshipFromDB($args['code'])){
			throw new genException("Scholarship Delete failed?");
		}
		return $response->withJson(messageResponse(true,$args['code']." successfully deleted.".$result));
		
	});
});

/*
Get all scholarships
	/scholarships/ 						GET
Submit new scholarship
	/scholarships/						POST
Get Specific Scholarship
	/scholarships/:id 					GET
Delete Scholarship 
	/scholarships/:id 					DELETE

Modify Scholarship
	/scholarships/ 						PUT
	/scholarships/:id 					PUT
Get Scholarships with Requirements
	/scholarships/?a=1&b=2&				GET
Check if Scholarship ID fits Requirements
	/scholarships/:id/?a=1$b=2			GET


*
{
	"code":"",
	"name":"",
	"description":"",
	"active":true/false,
	"bound":#
	"question": // Questions may be submitted as only id, or entire question objects. If question object already exists, it reuses
	[
		1?{
			"id":#,
			?"keyword_list":#
		},
		2?{
			"type":#,
			"question":"",
			"settings":{
			
			}
		},
	]
}


*/
?>