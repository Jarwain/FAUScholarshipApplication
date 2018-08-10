<?php
namespace ScholarshipApi\Model\Qualifier;

abstract class Qualifier implements \JsonSerializable{
    use \ScholarshipApi\Model\PropTrait;
    protected $id;
    protected $name;
    protected $question;

    protected $type;
    const TYPE_BOOL = 'bool';
    const TYPE_RANGE = 'range';
    const TYPE_SELECT = 'select';

    private $requiredProps = [];
    private $optionalProps = ['required'];

    function __construct($id, $name, $question, $props = []){
        $this->id = $id;
        $this->name = $name;
        $this->question = $question;
        $this->setProps($props);

        $this->checkRequiredProps();
    }

    abstract function validate($term, $valid = Null);

    function jsonSerialize(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'question' => $this->getQuestion(),
            'type' => $this->getType(),
            'possibleProps' => $this->getPossibleProps(),
            'props' => $this->getProps()
        ];
    }

    function getId(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getType(){
        return $this->type;
    }
    function getQuestion(){
        return $this->question;
    }
}
