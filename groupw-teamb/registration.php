<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TeamBLand</title>
        <link rel="stylesheet" type="text/css" href="main.css" >
    </head>
    <body>
       <div id ="wrapper"> 
        <h1>Registration</h1>
        <strong>First Name: </strong>Must start with a letter and be 1-25 Characters in length.<br>
         <strong>Last Name: </strong>Must start with a letter and be 1-25 Characters in length.<br>
         <strong>Email: </strong>Must be a valid email address and unique to you. <br>
         <strong>Alias: </strong>Must be 4-30 characters in length and unique to you. <br>
         <strong>Password: </strong>Must be at least 10 characters long, and have 3 of the following-
         <ul>
             <li>1 uppercase character </li>
             <li>1 lowercase character</li>
             <li>1 digit (0-9)</li>
             <li>1 special character</li>
         </ul>
            
        <form action="." method="post">
            <input type="hidden" name="action" value="add_user">
            <label for="first_name">First Name: </label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name) ?>">
            <span class="invalid"><?php echo htmlspecialchars($fNameErr) ?></span>
            <br>
            <label for="last_name">Last Name: </label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name) ?>">
            <span class="invalid"><?php echo htmlspecialchars($lNameErr) ?></span>
            <br>
            <label for="email">Email: </label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
            <span class="invalid"><?php echo htmlspecialchars($emailErr) ?></span>
            <br>
            <label for="alias">Alias: </label>
            <input type="text" name="alias" value="<?php echo htmlspecialchars($alias) ?>">
            <span class="invalid"><?php echo htmlspecialchars($aliasErr) ?></span>
            <br>
            <label for="password">Password: </label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
            <span class="invalid"><?php echo htmlspecialchars($passwordErr) ?></span>
            <br>
            <input id="register" type="submit" value="Register">
        </form>
        <form class="cancel" action="." method="post">
            <input type="submit" value="Cancel">
        </form>
       </div>
    </body>
    
</html>
