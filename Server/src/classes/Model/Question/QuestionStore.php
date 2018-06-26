<?php 
namespace ScholarshipApi\Model\Question;

interface QuestionStore{
    function getAll();
    function get($id);
}
