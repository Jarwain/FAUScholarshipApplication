<?php
namespace ScholarshipApi\Model;

abstract class AbstractRepository{
    private $local = Null;
    private $store;

    function __construct(AbstractStore $store){
        $this->store = $store;
    }

    protected function getStore(){
        return $this->store;
    }

    function getAll(){
        $this->local = $this->local ?? $this->store->getAll();
        return $this->local;
    }

    function get($id){
        $item = $this->local[$id] ?? $this->store->get($id);
        return $item;
    }

    function save($item){
        return $this->store->save($item);
    }

    function delete($id){
        return $this->store->delete($id);
    }
}