<?php
namespace ScholarshipApi\Model;

abstract class AbstractRepository{
    private $local = Null;
    private $source;

    function __construct(AbstractStore $source){
        $this->source = $source;
    }

    function getAll(){
        $this->local = $this->local ?? $this->source->getAll();
        return $this->local;
    }

    function get($id){
        $item = $this->local[$id] ?? $this->source->get($id);
        return $item;
    }

    function create($item){
        return $this->source->create($item);
    }
}