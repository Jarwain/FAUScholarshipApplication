<?php 
namespace ScholarshipApi\Model\Scholarship;

interface ScholarshipStore{
    // TODO: Simplify Online/Offline to 'types'. Applicable vs Normal, or whatnot.
    // OOOR use a tag based system
    function get($code);
    function getAll();
    function getOnline();
    function getOffline();

    function create($scholarship);
    // function update($scholarship);
}
