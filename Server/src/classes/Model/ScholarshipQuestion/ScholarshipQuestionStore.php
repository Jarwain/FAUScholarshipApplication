<?php 
namespace ScholarshipApi\Model\ScholarshipQuestion;

interface ScholarshipQuestionStore{
    function getAll();
    function get($code);

    function create($code, $question);
}
