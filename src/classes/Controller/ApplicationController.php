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

    // TODO: Refactor
    public function save(Request $request, Response $response){
        $students = $this->container->get('StudentStore');
        $fileStore = $this->container->get('FileStore');
        $applicationStore = $this->container->get('ApplicationStore');

        [
            'student' => $student, 
            'answers' => $answers
        ] = $request->getParsedBody();

        try {
            $students->get($student['znumber']);
        } catch(\OutOfBoundsException $e) {
            // If Student does not exist...
            $students->save($student);
        }

        /* http://php.net/manual/en/features.file-upload.post-method.php */
        ['answers' => $files] = $request->getUploadedFiles();
        // Save File and store ID as answer
        foreach($files as $code => $answer){
            foreach($answer as $question => $file){
                $item['znumber'] = $student['znumber'];
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

        // Turn answers into application, and save it
        foreach($answers as $code => $answer){
            $application = [
                'znumber' => $student['znumber'],
                'code' => $code,
                'answers' => $answer,
            ];
            try{
                $applicationStore->save($application);
                $result[$code] = "Success!";
            } catch(\Exception $ex) {
                $result[$code] = $ex->getMessage();
            }
        }

        return $response->withJson([$result, $student, $answers]);
    }
}
