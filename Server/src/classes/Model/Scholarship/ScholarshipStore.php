<?php 
namespace ScholarshipApi\Model\Scholarship;

interface ScholarshipStore{
    // TODO: Simplify Online/Offline to 'types'. Applicable vs Normal, or whatnot.
    function get($code);
    function getAll();
    function getOnline();
    function getOffline();
}