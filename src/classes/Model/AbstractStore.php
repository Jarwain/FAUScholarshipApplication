<?php 
namespace ScholarshipApi\Model;

interface AbstractStore{
    function get($id);
    function getAll();

    function create($item);
    // function update($item);
}
