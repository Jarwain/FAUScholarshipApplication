<?php
namespace ScholarshipApi\Model\Question;

abstract class Question implements \JsonSerializable{
    use \ScholarshipApi\Model\PropTrait;
    public $id;
    public $question;

    public $type;
    const TYPE_ESSAY = 'essay';
    const TYPE_FILE = 'file';
    const TYPE_VIDEO = 'video';

    private $requiredProps = [];
    private $optionalProps = ['optional'];

    function __construct($id, $question, $props = []){
        $this->id = $id;
        $this->question = $question;
        $this->setProps($props);

        $this->checkRequiredProps();
    }

    function jsonSerialize(){
        return [
            'id' => $this->getId(),
            'question' => $this->getQuestion(),
            'type' => $this->getType(),
            'possibleProps' => $this->getPossibleProps(),
            'props' => $this->getProps()
        ];
    }

    function isOptional(){
        $optional = $this->getProp('optional');
        if(is_null($optional))
            return False;
        else
            return $optional;
    }

    function getId(){
        return $this->id;
    }

    function getType(){
        return $this->type;
    }

    function getQuestion(){
        return $this->question;
    }
}
