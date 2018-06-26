<?php 
namespace ScholarshipApi\Model\Requirement;

interface RequirementStore{
    function get($code);
    function getAll();

    function create($code, $data);
}
