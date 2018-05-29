<?php 
namespace ScholarshipApi\Model\Requirement;

interface RequirementStore{
    function get($code, $category = NULL, $qualifier_id = NULL);
    function getAll();
}