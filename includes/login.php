<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login">
        <div class="hero"></div>
        <div class="login-content">
            <div class="logo"></div>
            <h1>Bienvenido de vuelta</h1>
            <form class="login-form" action="./login-session.php" method="post">
                <label for="username">Nombre de usuario</label>
                <input type="text" name="username" id="username" placeholder="example_123">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password">
                <?php
                    if (isset($_GET["info"])) {
                        switch($_GET["info"]) {
                            case 1:
                                echo "<p class=''>Usuario o contraseña incorrectos.</p>";
                                break;
                            case 2:
                                echo "<p class=''>Se ha cerrado la sesión correctamente.</p>";
                                break;
                            default:
                        }
                    }
                ?>
                <p class="info"></p>
                <input type="submit" value="ACCEDER">
            </form>
        </div>
    </div>
</body>
</html>