<?php
namespace ScholarshipApi\Entity;

use ScholarshipApi\Entity\Qualifier;

class Requirement{
    var $id;
    var $scholarship_code;
    var $category;
    var $qualifier;
    var $valid;

    // TODO: (maybe)Refactor so that there's $pass and $fail

    function __construct($id = NULL, $scholarship_code, $category, $qualifier, $valid){
        $this->id = $id;
        $this->scholarship_code = $scholarship_code;
        $this->category = $category;
        $this->qualifier = $qualifier;
        $this->valid = $valid;
    }

    static function Factory(array $data){
        $data['valid'] = isset($data['valid']) ? json_decode($data['valid'], true) : NULL;
        return new Requirement($data['id'] ?? NULL, $data['sch_code'], $data['category'], $data['qualifier'] ?? $data['qualifier_id'], $data['valid']);
    }

    static function BulkFactory($data, $qualifiers){
        $requirements = [];
        foreach($data as $r){
            $r['qualifier'] = $qualifiers[$r['qualifier_id']];
            $req = Requirement::Factory($r);
            $requirements[$req->scholarship_code][$req->category][$req->qualifier->id] = $req;
        }

        return $requirements;
    }
}