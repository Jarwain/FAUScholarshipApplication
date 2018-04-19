<?php
namespace FAUScholarship\API\Store;

interface ScholarshipInterface {
    public function getScholarships();
    public function getScholarship($code);
    public function createScholarship($scholarship);
    // public function createScholarships(array $scholarships);
    // public function updateScholarship();
    // public function updateScholarships(array $scholarships);
    // public function toggleScholarshipActive();

}
