<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TeamBLand</title>
        <link rel="stylesheet" type="text/css" href="main.css" >
    </head>
    <body>
        <div id ="wrapper">
            <h1>Login to your account...</h1>

            <main>
                <h2 class="invalid"><?php echo htmlspecialchars($error_message) ?></h2>

                <form action="index.php" method="post">
                    <!--for the control-->
                    <input type="hidden" name="action" value="login">

                    <label>User Name</label>
                    <input type="text" name="userName"> <br>
                    <label>Password</label>
                    <input type="password" name="password"> <br>

                    <input type="submit" value="Login">

                </form>
                <form class="cancel" action="." method="post">
                    <input type="submit" value="Cancel">
                </form>
                <br>

                <h2>Or <a href=".?action=register">register</a> for a new account</h2>
            </main>
        </div>

    </body>
</html>
