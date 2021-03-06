<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

abstract class AbstractController {
    protected $container;

	public function __construct(ContainerInterface $container){
		$this->container = $container;
	}
}
