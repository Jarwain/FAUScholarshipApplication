<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

use ScholarshipApi\View\ViewBuilder;
use ScholarshipApi\View\ApplicationView;
use ScholarshipApi\Model\Student\Student;
use ScholarshipApi\Util\ValidationException;


class ApplicationController extends AbstractController{
    protected $session;
    protected $renderer;

    public function __construct(ContainerInterface $container){
        parent::__construct($container);
        $this->session = $container->get('session');        
        $this->renderer = $container->get('renderer');
    }

    public function index(Request $request, Response $response, $args){
    	// Objects will be passed into JavaScript as
        // FAUObj.$name
        $data['obj'] = [
            'questions' => $this->container->get('QuestionStore')->getAll(),
    		'qualifiers' => $this->container->get('QualifierStore')->getAll(),
            'scholarships' => $this->container->get('ScholarshipStore')->getActive(),
    	];

    	return $this->renderer->render($response, '../dist/application.phtml', $data);
    }

    // TODO: Refactor
    public function save(Request $request, Response $response){
        $students = $this->container->get('StudentStore');
        $fileStore = $this->container->get('FileStore');
        $applicationStore = $this->container->get('ApplicationStore');
        try {
            [
                'student' => $student, 
                'answers' => $answers
            ] = $request->getParsedBody();

            if(empty($answers)){
                throw new Exception("No Applications To Submit");
            }

            $savedStudent = $students->get($student['znumber']);
            // If Student does not exist...
            if(is_null($savedStudent)){
                $student = Student::DataMap($student);
                $students->save($student);
            } else {
            // Student Exists
                // Student has videoAuth set
                if(isset($student['videoAuth'])){
                    // Update saved student
                    $savedStudent->videoAuth = $student['videoAuth'];
                    $students->save($savedStudent);
                }
                // If student has changed any qualifiers/qualifications
                // It's not saved.
                $student = $savedStudent;
            }

            $filesUploaded = $request->getUploadedFiles();
            if($filesUploaded){
                /* http://php.net/manual/en/features.file-upload.post-method.php */
                ['answers' => $files] = $filesUploaded;
                // Save File and store ID as answer
                foreach($files as $code => $answer){
                    foreach($answer as $question => $file){
                        $item['znumber'] = $student->znumber;
                        $fileData = $file->getStream()->getContents();
                        $item['file'] = [
                            'name' => $file->getClientFilename(),
                            'size' => $file->getSize(),
                            'data' => $fileData,
                            'md5' => md5($fileData),
                        ];
    
                        $answers[$code][$question] = $fileStore->save($item);
                    }
                }
            }

            // Turn answers into application, and save it
            foreach($answers as $code => $answer){
                $application = [
                    'znumber' => $student->znumber,
                    'code' => $code,
                    'answers' => $answer,
                ];
                try{
                    // Todo: Validate that application has all required answers
                    $applicationStore->save($application);
                    $result['message'][$code] = [
                        'status' => true,
                        'message' => "Success!",
                    ];
                } catch(\Exception $ex) {
                    $result['message'][$code] = [
                        'status' => false,
                        'message' => $ex->getMessage(),
                    ];
                }
            }
        } catch(\Exception $ex) {
            $result['status'] = false;
            $result['message'] = $ex->getMessage();
            return $response->withJson($result);
        }
        $result['status'] = true;
        return $response->withJson($result);
    }
}
