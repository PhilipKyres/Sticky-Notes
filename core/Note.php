<?php
//Author: Philip Kyres
//A class for Note objects. Is serializable into json objects using json_encode
class Note implements JsonSerializable {
    
    private $id;
    private $text;
    private $x;
    private $y;
    
    function __construct($pId = null, $pText = null, $pX = null, $pY = null){

        if(isset($pId))
            $this->setId($pId);

        if(isset($pText))
            $this->setText($pText);

        if(isset($pX))
            $this->setX($pX);

        if(isset($pY))
            $this->setY($pY);
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
    
    public function getId(){
        return $this->id;
    }

    public function setId($pId){
        if($pId < 1)
            throw new InvalidArgumentException('Invalid id '.$pId);
        $this->id = $pId;
    }

    public function getText(){
        return $this->text;
    }

    public function setText($pText){
        require_once('Util.php');
        if(!isset($pText))
            throw new InvalidArgumentException('Invalid text');
        $this->text = $pText;
    }

    public function getX(){
        return $this->x;
    }

    public function setX($pX){
        $this->x = $pX;
    }

    public function getY(){
        return $this->y;
    }

    public function setY($pY){
        $this->y = $pY;
    }
}
?>