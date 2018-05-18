<?php
namespace ScholarshipApi\Repository\DataAccessObject;

/* 
 *  Create
 *  Read
 *  Update
 *  Delete
 */
interface Crud {
    public function get($id);
    public function getAll();
    /*public function save($obj);
    public function saveAll(array $obj);
    public function update($obj);
    public function updateAll(array $obj);
    public function delete($id);*/
}