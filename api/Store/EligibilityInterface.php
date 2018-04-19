<?php
namespace FAUScholarship\API\Store;

interface EligibilityInterface {
    public function getRequirements();
    public function getRequirementForScholarship($code);
    public function getQualifiers();
    
    // Create
    // Update
    // Delete
}
