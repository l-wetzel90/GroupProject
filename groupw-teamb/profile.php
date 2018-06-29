<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TeamBLand</title>
        <link rel="stylesheet" type="text/css" href="main.css" >
    </head>
    <body>
        <div id="wrapper">
            <header><h1><?php echo htmlspecialchars("$first_name $last_name's  Profile") ?></h1></header>
            <?php include ('userSidebar.php'); ?>
            <main>
                <p><?php echo htmlspecialchars("$first_name $last_name") ?></p><br>
                <p><img src="<?php echo htmlspecialchars($profile_image) ?>" alt="profile image" height="100" width="100"></p>
                <p>Email is <?php echo htmlspecialchars($email) ?></p>
                <p>Alias is <?php echo htmlspecialchars($alias)?></p>

                <p><a href=".?action=view_edit">Edit Info</a></p>

                <form action="." method="post">
                    <input type="hidden" name="action" value ="logout">
                    <input type="submit" value="Log Out">
                </form>
                <br>

                <table>
                    <tr>
                        <th>Comment:</th>
                        <th>Made By:</th>
                        <th>On:</th>

                    </tr>
                    <?php foreach ($comments as $comment) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($comment->GetComment()); ?></td>
                            <td><?php echo htmlspecialchars($comment->GetCommentMadeBy()); ?></td>
                            <td><?php echo htmlspecialchars($comment->GetCommentDate()); ?></td>


                            </form></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <h3> View Other User</h3>        
                <form action="." method="post">
                    <input type="hidden" name="action" value="view_others_profile">

                    <label for="alias">Alias: </label>
                    <input type="text" name="alias" value="">

                    <br>

                    <input id="register" type="submit" value="View">
                </form>
            </main>
        </div>
    </body>
</html>
