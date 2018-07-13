<?php
namespace ScholarshipApi\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use \Interop\Container\ContainerInterface;

abstract class AbstractController {
    protected $container;

    public abstract function __construct(ContainerInterface $container);
}