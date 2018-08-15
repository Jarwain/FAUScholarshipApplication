<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\View\ViewBuilder;
use ScholarshipApi\View\ApplicationView;

class ApplicationController extends AbstractController{
    protected $session;
    protected $renderer;

    public function __construct(ContainerInterface $container){
        parent::__construct($container);
        $this->session = $container->get('session');        
        $this->renderer = $container->get('renderer');
    }

    public function index(Request $request, Response $response, $args){
    	$qualifiers = $this->container->get('QualifierStore')->getAll();
    	$data['obj'] = [
    		'qualifiers' => $qualifiers
    	];

    	return $this->renderer->render($response, '../dist/application.phtml', $data);
    }

    public function save(Request $request, Response $response){
        $students = $this->container->get('StudentStore');
        $fileStore = $this->container->get('FileStore');
        $scholarshipStore = $this->container->get('ScholarshipStore');
        $applicationStore = $this->container->get('ApplicationStore');

        $files = $request->getUploadedFiles();
        /* http://php.net/manual/en/features.file-upload.post-method.php */
        [
            'student' => $student, 
            'applications' => $applications
        ] = $request->getParsedBody();

        try {
            $students->get($student['znumber']);
        } catch(\OutOfBoundsException $e) {
            // If Student does not exist...
            $students->save($student);
        }

        foreach($files as $question=>$file){
            $file['md5'] = md5_file($file['tmp_name']);
            $file['data'] = file_get_contents($data['tmp_name']);
            $file['znumber'] = $student['znumber'];
            $answers[$question] = $fileStore->save($file);
        }

        foreach($scholarships as $code){
            $sch = $scholarshipStore->get($code);
            $application = [
                'znumber' => $student['znumber'],
                'code' => $code,
                'answers' => []
            ];
            foreach($sch->getQuestions() as $question){
                $application['answers'][] = $answers[$question->getId()];
            }
            $applicationStore->save($application);
        }

        
        // Turn answers into applications
        // Save application
        // Return success or not

        return $response->withJson(["You have successfully submitted applications!", $student, $scholarships, $answers]);
    }
}
