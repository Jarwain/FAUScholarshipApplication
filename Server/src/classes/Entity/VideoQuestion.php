<?php
namespace ScholarshipApi\Entity;

class VideoQuestion extends Question{
    function __construct($id = NULL, $question){
        parent::__construct($id, $question, 'video');
    }
}