<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TeamBLand</title>
        <link rel="stylesheet" type="text/css" href="main.css" >
    </head>
    <body>
        <div id ="wrapper">

            <h1><?php echo htmlspecialchars("$first_name $last_name's  Profile") ?></h1>
            
            <?php include ('userSidebar.php'); ?>
            
            <main>
                <p><?php echo htmlspecialchars("$first_name $last_name") ?></p><br>
                <p><img src="<?php echo htmlspecialchars($profile_image) ?>" alt="profile image" height="100" width="100"></p>
                <p>Email is <?php echo htmlspecialchars($email) ?></p>
                <p>Alias is <?php echo htmlspecialchars($alias) ?></p>

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

                <?php if (!empty($_SESSION['user'])){ ?>
                    
                    <h3>Add comment</h3>
                    <form action="." method="post" id="aligned">
                        <input type="hidden" name="action" value="add_comment">
                        <input type="hidden" name="commentFor" value="<?php echo htmlspecialchars($alias) ?>">
                               <label>Comment:</label>
                        <input type="text" name="theComment"><br>

                        <label>&nbsp;</label>
                        <input type="submit" value="Add Comment"><br>
                    </form>
                <?php } ?>
                <p><a href=".?action=profile">Home</a></p>
            </main>
        </div>
    </body>
</html>
