<?php
class User {
    private $first_name;
    private $last_name;
    private $alias;
    private $email;
    private $profile_image;
    
    public function __construct($first_name, $last_name, $alias, $email, $image = "/images/default.png"){       
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->alias = $alias;
        $this->email = $email;
        $this->profile_image = $image;
    }
    
    public function getFirstName(){
        return $this->first_name;
    }
    public function setFirstName($first_name){
        $this->first_name = $first_name;
    }
    
    public function getLastName(){
        return $this->last_name;
    }
    public function setLastName($last_name){
        $this->last_name = $last_name;
    }
    
    public function getAlias(){
        return $this->alias;
    }
    // Since we can't edit user name do we need a setter?
    
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    
    public function getProfileImage(){
        return $this->profile_image;
    }
    public function setProfileImage($image){
        $this->profile_image = $image;
    }
    
    public function getFullName(){
        return $this->first_name . " " . $this->last_name;
    }
}

?>