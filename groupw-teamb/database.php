<?php
    $dsn = 'mysql:host=localhost;dbname=teambwebsite1';
    $username = 'root';
    $password = '';

    try {
        $db= new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Its all broken qq";
        // This is debugging stuff
        //echo htmlspecialchars($e->getMessage());
        //Displays the exception and keeps on rolling, uncomment the exit if you want it to halt instead
        exit();
    }
    
    //gets all users if we need it
    function get_all_users()
    {
        global $db;
 
      $query = 'SELECT * FROM users';
      $statement = $db->prepare($query);
      $statement->execute();
      $results =  $statement->fetchAll();
      $users = [];
      foreach ($results as $result){
          $users[] = new User($result["fName"], $result["lName"], $result["alias"],
                  $result["email"], $result["pimage"]);
      }
      return $users;
    }
    
    //inserts user into database
    function insert_users($fName, $lName, $alias, $email, $password, $pimage){
        global $db;
        $query = 'insert into users
                    (fName, lName, alias, email, password, pimage) 
                    VALUES 
                    (:fNamePlace, :lNamePlace, :aliasPlace, :emailPlace, :passwordPlace, :pimagePlace)';
        
         $statement = $db->prepare($query);
    $statement->bindValue(':fNamePlace', $fName);
    $statement->bindValue(':lNamePlace', $lName);
    $statement->bindValue(':aliasPlace', $alias);
    $statement->bindValue(':emailPlace', $email);
    $statement->bindValue(':passwordPlace', $password);
    $statement->bindValue(':pimagePlace', $pimage);

    $statement->execute();
    $userId = $db->lastInsertId();
    $statement->closeCursor();
    
    return $userId;
    }
    
    //uses sql to validate alias is unique
    function alias_exist($alias){
        global $db;
        //checks all user names for duplicates
        $query = 'select * from users
                    where alias = :aliasPlace';
        $statement = $db->prepare($query);
        $statement->bindValue(':aliasPlace', $alias);
        
        $statement->execute();
        $results = $statement->fetch();//returns results of select statement if anything
        $statement->closeCursor();
        
        if(empty($results)){
            $exists = false;
        }else {
            $exists = true;
        }
        
        return $exists;
    }
    
    //uses sql to validate email is unique
    function email_exist($email){
        global $db;
        //checks all emails for duplicates
        $query = "SELECT * FROM users WHERE email = :emailPlace";
        $statement = $db->prepare($query);
        $statement->bindValue(':emailPlace', $email);
        
        $statement->execute();
        $results = $statement->fetchAll();//returns results of select statement if anything
        $statement->closeCursor();
        
        if(empty($results)){
            $exists = false;
        }else {
            $exists = true;
        }
        
        return $exists;
    }

    function get_hashed_password($alias){
        global $db;
        //looks for the alias
        $query = "SELECT password FROM users WHERE alias = :aliasPlace";
        $statement = $db->prepare($query);
        $statement->bindValue(':aliasPlace', $alias);
        
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        $hashed_password = $results[0]['password'];
        return $hashed_password;
    }
    
    function get_user($alias){
        global $db;
        // not returning the password becuase we probably shouldn't.
        $query = "SELECT fName, lName, alias, email, pimage "
                . "FROM users WHERE alias = :aliasPlace";
        $statement = $db->prepare($query);
        $statement->bindValue(':aliasPlace', $alias);
        
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        return $results[0];
    }
        //edit existing user
    function edit_users($fName, $lName, $email, $password, $alias, $pimage){
        global $db;
        $query = 'update users
                    set fName = :fNamePlace, lName = :lNamePlace, email = :emailPlace, password = :passwordPlace, pimage = :pimagePlace
                    where alias=:aliasPlace';
        
         $statement = $db->prepare($query);
    $statement->bindValue(':fNamePlace', $fName);
    $statement->bindValue(':lNamePlace', $lName);
    $statement->bindValue(':aliasPlace', $alias);
    $statement->bindValue(':emailPlace', $email);
    $statement->bindValue(':passwordPlace', $password);
    $statement->bindValue(':pimagePlace', $pimage);

    $statement->execute();
 
    $statement->closeCursor();
    
    return; //$userId;
    }
    //edits the user without having to change password
    function edit_users_no_password_change($fName, $lName, $email, $alias, $pimage){
        global $db;
        $query = 'update users
                    set fName = :fNamePlace, lName = :lNamePlace, email = :emailPlace, pimage = :pimagePlace
                    where alias=:aliasPlace';
        
         $statement = $db->prepare($query);
    $statement->bindValue(':fNamePlace', $fName);
    $statement->bindValue(':lNamePlace', $lName);
    $statement->bindValue(':aliasPlace', $alias);
    $statement->bindValue(':emailPlace', $email);
    $statement->bindValue(':pimagePlace', $pimage);

    $statement->execute();
 
    $statement->closeCursor();
    
    return; //$userId;
    }
   //COMMENTS FUNCTIONS
    
        function getComments($commentFor) {
        global $db;

        $query = 'SELECT * FROM comments
                  where commentFor = :commentFor
                  ORDER BY commentDate';
                  
        $statement = $db->prepare($query);
        $statement->bindValue(':commentFor', $commentFor);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        
        $comments = array();
        foreach($rows as $row) {
            $c = new comment(
                    $row['commentFor'], $row['commentMadeBy'],
                    $row['comment'], $row['commentDate']);
            //$c->setID($row['ID']);
            $comments[] = $c;
        }
        return $comments;
    }
    
     function addComment($t) {
        global $db;
        
        $query = 'INSERT INTO comments
                     (commentFor, commentMadeBy, comment, commentDate)
                  VALUES
                     (:commentFor, :commentMadeBy, :comment, current_timestamp)';
        $statement = $db->prepare($query);
        $statement->bindValue(':commentFor', $t->getCommentFor());
        $statement->bindValue(':commentMadeBy', $t->getCommentMadeBy());
        $statement->bindValue(':comment', $t->getComment());
       // $statement->bindValue(':commentDate', $t->getCommentDate());
        $statement->execute();
        $statement->closeCursor();
    }
    
    function get_users_by_comment_total() {
        global $db;
        
        $query = 'SELECT u.*, COUNT(c.commentID) as numComments FROM users u
                  LEFT JOIN comments c
                  ON u.alias = c.commentFor
                  GROUP BY u.alias
                  ORDER BY numComments DESC, alias ASC
                  LIMIT 5';
        $statement = $db->prepare($query);
        $statement->execute();
        $results =  $statement->fetchAll();
        $users = [];
        foreach ($results as $result){
            $users[] = new User($result["fName"], $result["lName"], $result["alias"],
                                $result["email"], $result["pimage"]);
        }
        return $users;
    }
?>
