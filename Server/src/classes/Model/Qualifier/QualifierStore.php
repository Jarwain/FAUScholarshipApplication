<?php 
namespace ScholarshipApi\Model\Qualifier;

interface QualifierStore{
    function get($code);
    function getAll();
}