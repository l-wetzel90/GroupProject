<?php
require_once('database.php');




//functions
function isValidFirstName($fName) {
    $isValid = false;
    if(preg_match("/^[a-zA-Z][a-zA-Z0-9]{0,24}$/"/*taken from course website*/, $fName )){
        $isValid=true;
    }
    return $isValid;
}

function isValidLastName($lName) {
    $isValid = false;
    if(preg_match("/^[a-zA-Z][a-zA-Z0-9]{0,24}$/"/*taken from course website*/, $lName )){
        $isValid=true;
    }
    return $isValid;

}

function isValidAlias($alias) {
    $isValid = false;
    $strlength = strlen($alias);
    // I'm not sure why I have to but it keeps escaping my ending bracket if I use [\/\\]
    // adding the extra \ makes it work but none of the regex testers agree...
    // My best guess, while it shouldn't be doing it in a character class its translating \\ into \ which is escaping the next character
    if(strlen($alias) > 3 && 
            strlen($alias) < 31 && 
            preg_match("/[\/\\\<\>:\"|\?*\.]/", $alias )===0 && 
            preg_match("/^\s/", $alias) === 0 &&
            preg_match("/\s$/", $alias) === 0){
        $isValid=true;
    }
    return $isValid;
    }


function isValidEmail($email) {
    $isValid = false;
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
         $isValid=true;
    }
    return $isValid;
}
function isValidPassword($password) {
    /*10 chars?*/
        $isValid = false;
        $minAcceptableValue=3;
        $minPasswordLength = 10;
        $counter=0;
        /*
    if(preg_match("/^.{9,}$/", $password )){
        $isValid=true;
    }*/
 
            if(hasOneUppercase($password)){
                $counter++; }
            if(hasOneLowercase($password)){
                $counter++;}
            if(hasOneDigit($password)){
                $counter++;}
            if(hasOneSpecialChar($password)){
                $counter++;}
    if($counter>=$minAcceptableValue &&  strlen($password) >= $minPasswordLength){
        return true;}        
    
    else {
        return false;}
    }

/********************************************/
/*password specific functions*/
/********************************************/
    
function hasOneUppercase($password){
        $isValid = false;
        $checker = preg_match("/[A-Z]/"/*taken from course website*/, $password );
    if(preg_match("/[A-Z]/"/*taken from course website*/, $password )===1){
        $isValid=true;
    }
    return $isValid;
}

function hasOneLowercase($password){
            $isValid = false;
    if(preg_match("/[a-z]/"/*taken from course website*/, $password )===1){
        $isValid=true;
    }
    return $isValid;
}
function hasOneDigit($password){
            $isValid = false;
    if(preg_match("/[0-9]/"/*taken from course website*/, $password )===1){      
        $isValid=true;
    }
    return $isValid;
    
}
function hasOneSpecialChar($password){
        $isValid = false;
    if(preg_match("/[!@#$%^&*()[\]{}\|;:,<.>\/?\-=_+]/"/*taken from course website*/, $password )===1){
        $isValid=true;
    }
    return $isValid;
    
}
?>