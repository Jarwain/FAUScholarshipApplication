<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;

require_once("/../controllers/ScholarshipController.php");


$this->group('/scholarships', function() {

	$this->get('/[{code}/]', function($request, $response, $args){
		$schcontrol = new ScholarshipController($this->db);
		// Check for code to determine which scholarships to return
		if(array_key_exists('code',$args) && !$schcontrol->exists($args['code'])){
			throw new genException($args['code'] . " does not exist.".$schcontrol->exists($args['code'])."wat");
		} else if(!array_key_exists('code',$args)){
			$args['code'] = null;
		}
		
		$result1 = $schcontrol->getScholarship($args['code']);
		$result2 = $schcontrol->getScholarshipsAndQuestions($args['code']);
		
		// TODO: Decide on which implementation to use...
		return $response->withJson(["R1"=>$result1, "R2"=>$result2]);
	});

	$this->post('/', function($request, $response){
		$scholarship = new Scholarship($request->getParsedBody());
		$schcontrol = new ScholarshipController($this->db);
		if(!$schcontrol->saveScholarship($scholarship)){
			throw new genException("Scholarship Post/Save failed?");
		}

		return $response->withJson(
			messageResponse(true, 
							$scholarship->code . " added successfully",
							["scholarship"=>$schcontrol->getScholarship($scholarship->code)]
							));
	});

	$this->delete('/{code}/', function($request, $response, $args){
		if(!$schcontrol->deleteScholarship($args['code'])){
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