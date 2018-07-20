<?php 
namespace ScholarshipApi\Model;

interface AbstractStore{
    function get($id);
    function getAll();

    function save($item);
    function delete($id);
}
