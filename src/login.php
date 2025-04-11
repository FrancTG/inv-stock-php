<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login">
        <div class="hero"></div>
        <div class="login-content">
            <div class="logo"></div>
            <h1>Welcome back</h1>
            <form class="login-form" action="./login-session.php" method="post">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="e.g. myusername-123">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <?php
                    if (isset($_GET["info"])) {
                        switch($_GET["info"]) {
                            case 1:
                                echo "<p class=''>Incorrect username or passoword</p>";
                                break;
                            case 2:
                                echo "<p class=''>You have been logged out successfully</p>";
                                break;
                            default:
                        }
                    }
                ?>
                <p class="info"></p>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>