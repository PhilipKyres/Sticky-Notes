<?php
//Author: Philip Kyres
//A utility class with some utility methods
	function IsNullOrEmptyString($s){
	    return (!isset($s) || trim($s)==='');
	}

	function getHashedString($pString){
        return password_hash($pString, PASSWORD_DEFAULT);
    }
?>