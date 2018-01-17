<?php
//Author: Philip Kyres
//A class for User objects
class User{
    
    private $user_id;
    private $username;
    private $password;
    
    function __construct($pUserId, $pUsername, $pPassword){
        $this->setUserId($pUserId);
        $this->setUsername($pUsername);
        $this->setPassword($pPassword);
    }
    
    public function getUserId(){
        return $this->user_id;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }
    
    private function setUserId($pUserId){
        if ($pUserId < 1)
            throw new InvalidArgumentException('Invalid user id');
        $this->user_id = $pUserId;
    }

    private function setUsername($pUsername){
        require_once('Util.php');
        if (IsNullOrEmptyString($pUsername))
            throw new InvalidArgumentException('Invalid username');
        $this->username = $pUsername;
    }

    private function setPassword($pPassword){
        require_once('Util.php');
        if (IsNullOrEmptyString($pPassword))
            throw new InvalidArgumentException('Invalid password');
        $this->password = $pPassword;
    }
}
?>