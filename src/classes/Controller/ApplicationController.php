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
        $this->container = $container;
        $this->session = $container->get('session');        
        $this->renderer = $container->get('renderer');
    }

    public function studentInfo(Request $request, Response $response){
        $qualifiers = $this->container->get('QualifierStore')->getAll();

        $view = new ViewBuilder('application/layout.phtml');
		$view = ApplicationView::navbar($view);
		$view = ApplicationView::studentForm($view, $qualifiers);

		return $view->render($this->renderer, $response);
    }
}