<?php
// creating session cookie with lifetime of 1 day
session_set_cookie_params(86400, '/');
session_start();
require_once('database.php');
require_once('commentClass.php');
require_once('User.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        // profile will check to see if the user is logged in and send
        // them to the profile if they are and the login page if not.
        $action = 'profile';
    }
}
//added this here as variable to be passed to all views instead of in each view
$usersSidebar = get_users_by_comment_total();
switch($action) {  
    
    case 'add_comment':
        $comment = trim(filter_input(INPUT_POST, 'theComment'));
        // Makes sure we have a user and validates we have input.
        if (!empty($_SESSION['user']) && !empty($comment)){
            $commentFor = filter_input(INPUT_POST, 'commentFor');
            $commentMadeBy = $_SESSION['user']['alias'];
            date_default_timezone_set('America/North_Dakota/Center');
            $commentDate = date('m/d/Y h:i:s a', time());

            // Create technician object
            $c = new comment($commentFor, $commentMadeBy, $comment, $commentDate);
            addComment($c);   
        }
        header('Location: index.php?action=view_others_profile&alias=' . $_SESSION['targetUser']['alias']);
        break;
   
    
        case 'view_others_profile':
        
        $alias = filter_input(INPUT_POST, 'alias');
        if ($alias===null){
            $alias = filter_input(INPUT_GET, 'alias');
        }     
         

        if(!empty($alias) && alias_exist($alias) ){
            $_SESSION['targetUser'] = get_user($alias);
            $first_name =  $_SESSION['targetUser']['fName'];
            $last_name =  $_SESSION['targetUser']['lName'];
            $email =  $_SESSION['targetUser']['email'];

            $profile_image =  $_SESSION['targetUser']['pimage'];
            $comments = getComments($alias);
            include('othersProfile.php');
        }
        else{
             header('Location: index.php?action=profile');
        }
        
                
        break;
    
    case 'login':
        
        $alias = filter_input(INPUT_POST, 'userName');
        $password = filter_input(INPUT_POST, 'password');
        
        if(!empty($alias) && alias_exist($alias) ){
            $stored_password = get_hashed_password($alias);
        }
        
        else{
            $error_message = "Invalid username password combination";
            $stored_password = "";
            include('login.php');
            exit();
        }
        
        if(password_verify($password, $stored_password)){
            $_SESSION['user'] = get_user($alias);
            header("Location: .");
            exit();
        } else{
            $error_message = "Invalid username password combination";
            include('login.php');
            exit();
        }
        break;
        
    case 'view_login':
        $error_message = "";
        include('login.php');
        exit();
        break;
        
    case 'profile':
        If (empty($_SESSION['user'])) {
            include('main.php');
            exit();
        } else {
            $first_name = $_SESSION['user']['fName'];
            $last_name = $_SESSION['user']['lName'];
            $email = $_SESSION['user']['email'];
            $alias = $_SESSION['user']['alias'];
            $profile_image = $_SESSION['user']['pimage'];
            $comments = getComments($alias);
            include('profile.php');
            exit();
        }
        break;
    
    case 'register':
        // create vars for use when registration is first loaded.
        $first_name = "";
        $last_name = "";
        $alias = "";
        $email = "";
        $password = "";

        $fNameErr = "";
        $lNameErr = "";
        $aliasErr = "";
        $emailErr = "";
        $passwordErr = "";
        // Take the user to the registration page.
        include('registration.php');
        exit();
        break;
    
    case 'add_user':
        include('validation.php');
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $alias = filter_input(INPUT_POST, 'alias');
        $email_string = filter_input(INPUT_POST, 'email');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        
        $isValid = true;
        
        //check first name
        if(!isValidFirstName($first_name)){
            $fNameErr = 'Invalid First Name';
            $isValid = false;
        }
        else{
            $fNameErr = '';
        }
        //check last name
        if(!isValidLastName($last_name)){
            $lNameErr = 'Invalid Last Name';
            $isValid = false;
        }
        else{
            $lNameErr = '';
        }
        //check email
        if(!isValidEmail($email)){
            $emailErr = 'Invalid Email';
            $email = $email_string;
            $isValid = false;
        }
        else if(email_exist($email)){
            //took this out of the email valid function so we could
            //show 2 different errors
            $emailErr = 'Email is Already Registered';
            $isValid = false;
        }
        else{
            $emailErr = '';
        }
        //check alias
        if(!isValidAlias($alias)){
            $aliasErr = 'Invalid Alias';
            $isValid = false;
        }else if(alias_exist($alias)){
            //took this out of the alias valid function so we could
            //show 2 different errors
            $aliasErr = 'User Name Already Taken';
            $isValid = false;
        }
        else{
            $aliasErr = '';
        }
        //check password
        if(!isValidPassword($password)){
            $passwordErr = 'Invalid Password';
            $isValid = false;
        }
        else{
            $passwordErr = '';
        }
        //go to 
        if($isValid){
            $pimage='images/default.jpg';
            insert_users($first_name, $last_name, $alias, $email, hash_password($password), $pimage);
            //added this line to put user into session after registered
            $_SESSION['user'] = get_user($alias);
            
            header("Location: .");
            exit();
        }
        else{
            include('registration.php');
            exit();
        }
        
    case 'view_edit':
        // If the user is not logged in go to login. If they are
        // create the vars for use on the edit page on first load.
        If (empty($_SESSION['user'])) {
            // this will default to action=profile which will send them to the 
            // login page with the error message set.
            header("Location: .");
            exit();
        } else {
            $first_name = $_SESSION['user']['fName'];
            $last_name = $_SESSION['user']['lName'];
            $email = $_SESSION['user']['email'];
            $password = "";

            $fNameErr = "";
            $lNameErr = "";
            $emailErr = "";
            $passwordErr = "";
            include('edit.php');
            exit();
        }
        break;
        
    case 'edit_user':
         include('validation.php');
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $email_string = filter_input(INPUT_POST, 'email');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        
        $isValid = true;
        
        //check first name
        if(!isValidFirstName($first_name)){
            $fNameErr = 'Invalid First Name';
            $isValid = false;
        }
        else{
            $fNameErr = '';
        }
        //check last name
        if(!isValidLastName($last_name)){
            $lNameErr = 'Invalid Last Name';
            $isValid = false;
        }
        else{
            $lNameErr = '';
        }
        //check email
        if ($email === $_SESSION['user']['email']){
            $emailErr = '';
        }
        elseif(!isValidEmail($email)){
                $emailErr = 'Invalid Email';
                // filter_validate_email will return false effectively clearing
                // the email if it isn't correct. Doing this to preserve input.
                $email = $email_string;
                $isValid = false;
            }
        else if(email_exist($email)){
            //took this out of the email valid function so we could
            //show 2 different errors
            $emailErr = 'Email is Already Registered';
            $isValid = false;
        }
        else{
            $emailErr = '';
        }
        //check password
        if(empty($password)){
            $passwordErr = '';
        }
        else if(!isValidPassword($password)){
            $passwordErr = 'Invalid Password';
            $isValid = false;
        }
        else{
            $passwordErr = '';
        }
        //go to 
        if($isValid){
            if(isset($_FILES['image'])){
                $valid = true;
                $file_name = $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $temp = explode('.', $file_name);
                $temp = end($temp);
                $extension = strtolower($temp);
                $valid_extensions = array("jpeg", "jpg", "png", "gif");

                if(in_array($extension, $valid_extensions) === false){
                    $valid = false;
                }

                if($valid){
                    $user_dir = "images/" . $_SESSION['user']['alias'];
                    if(!file_exists($user_dir)){
                        mkdir($user_dir);
                    }
                    $file_path = $user_dir . "/profileImage." . $extension;
                    move_uploaded_file($file_tmp, $file_path);
                    // doing this for things like aliases with % and other url encoded characters
                    $image_url = "images/" . rawurldecode($_SESSION['user']['alias']) . "/profileImage." . $extension;
                }
            }
            // profile image should be optional. Just pass back the current link
            // if no file is submitted.
            
            if(empty($file_path)){
                $image_url = $_SESSION['user']['pimage'];
            }
            if(empty($password)){
                edit_users_no_password_change($first_name, $last_name, $email, $_SESSION['user']['alias'], $image_url);
            }
            else{
                edit_users($first_name, $last_name, $email, hash_password($password), $_SESSION['user']['alias'], $image_url );
            }
            
            $_SESSION['user'] = get_user($_SESSION['user']['alias']);
            header("Location: .");
            exit();
        }
        else{
            include('edit.php');
            exit();
        }
        
        
        break;
        //logout the user
        case 'logout':
            session_unset();
            header("Location: .");
            exit();
            break;
        
}
function hash_password($password){
    $options = ['cost' => 12 ];
    return password_hash($password, PASSWORD_DEFAULT, $options);
}
?>
