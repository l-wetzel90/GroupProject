<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TeamBLand</title>
        <link rel="stylesheet" type="text/css" href="main.css" >
    </head>
    <body>
        <div id="wrapper">
        <h1>Edit Profile</h1>

        <main>
        You can edit your name, email and password here.<br> 
        Your new information must meet site requirements.
        <form action="." method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit_user">
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
            <label for="password">Password: </label>
            <input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
            <span class="invalid"><?php echo htmlspecialchars($passwordErr) ?></span>
            <br>
            <label for="image">Profile Image:</label>
            <input type="file" name ="image"/>
            <br>
            <input id="register" type="submit" value="Update">
        </form>
        <form class="cancel" action="." method="post">
            <input type="hidden" name="action" value="profile">
            <input type="submit" value="Cancel">
        </form>
        </main>
        </div>
    </body>
</html>
