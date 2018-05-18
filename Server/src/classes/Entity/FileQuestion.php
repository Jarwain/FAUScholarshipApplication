<?php
namespace ScholarshipApi\Entity;

class FileQuestion extends Question{
    var $filetype;
    var $sizeMaximum;

    const MAX_FILESIZE = 2097152; // ~2MB
    
    function __construct($id = NULL, $question, $filetype, $max = MAX_FILESIZE){
        parent::__construct($id, $question, 'file');
        $this->filetype = $filetype;
        $this->sizeMaximum = $max;
    }

    function Factory(array $data){
        
    }
}