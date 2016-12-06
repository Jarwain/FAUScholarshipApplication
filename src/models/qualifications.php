<?php

class Qualifications {
  public $id;
  public $type;
  public $field;
  public $values;

  function __construct(array $row){
    $this->id = $row['id'];
    $this->type = $row['type'];
    $this->field = $row['field'];
    $this->values = json_decode($row['values']);
  }
}