<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User details</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <?php require "../db.php"; require "../security.php";?>
</head>
<body>
    <main>
        <?php
            require "../includes/aside.php";

            $actionURL = "";
            $editing = false;

            if (isset($_GET["id"])) {
                $actionURL = './update-user.php';

                $SQL= "SELECT id,username,name,surnames,rol FROM users WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $editing = true;
            } else {
                $actionURL = './new-user.php';
                $editing = false;
            }
        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>User details</h1>";} else {echo "<h1>New user</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<button title='Update user' class='update' type='submit'><ion-icon name='refresh-outline'></ion-icon></button>";
                                echo "<button title='Delete user' class='delete' type='submit' formaction='./delete-user.php'><ion-icon name='trash-outline'></ion-icon></button>";
                            } else {
                                echo "<input class='add' type='submit' value='Create' />";
                            }
                        ?>
                    </div>

                    <input type="hidden" name="usr-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                
                    <label for="usr-username">User Name:</label>
                    <input id="usr-username" name="usr-username" type="text" placeholder="e.g. spiderman" value="<?php if (isset($row)) echo $row["username"] ?>">
                
                    <label for="usr-name">Name:</label>
                    <input type="text" name="usr-name" id="usr-name" placeholder="e.g. Tom"  value="<?php if (isset($row)) echo $row["name"] ?>"> 
                
                    <label for="usr-surnames">Surnames:</label>
                    <input type="text" name="usr-surnames" id="usr-surnames" placeholder="e.g. Holland" value="<?php if (isset($row)) echo $row["surnames"] ?>">
                
                    <?php
                        if ($editing == false) {
                            echo "<label for='usr-password'>Password:</label>
                            <input type='password' name='usr-password' id='usr-password' >";
                        }
                    ?>

                    <label for="usr-rol">Rol:</label>
                    <input type="text" name="usr-rol" id="usr-rol" placeholder="Is user or admin" value="<?php if (isset($row)) echo $row["rol"] ?>">                    
                </form>
                
            </div>
        </section>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>