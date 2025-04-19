<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <?php require "../db.php"; require "../security.php"; ?>
</head>
<body>
    <main>
        <?php require "../includes/aside.php"; ?>
        <section>
            <div class="items">            
                <div class="controls">
                    <form action="">
                        <ion-icon name="search-outline"></ion-icon>
                        <input type="text" name="search" id="search" placeholder="...">
                    </form>
                    <a href="./user-details.php" class="btn add"><ion-icon name="add-outline"></ion-icon> New</a>
                </div>
                <div class="list"> 
                    <?php
                        $SQL= "SELECT id,username,name,surnames,rol FROM users";

                        $res = $mysqli->query($SQL);

                        if ($res->num_rows > 0) {
                            // output data of each row
                            while($row = $res->fetch_assoc()) {

                                echo "<div class='list-item' >
                                <a href='./user-details.php?id=".$row["id"]."'>
                                    <div class='usr-id'>" . $row["id"] . "</div>
                                    <div class='usr-name'>" . $row["username"] . "</div>
                                    <div class='usr-username'>". $row["name"] . "</div>
                                    <div class='usr-surname'>". $row["surnames"] . "</div>
                                    <div class='usr-rol'>". $row["rol"] . "</div>
                                </a></div>";
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>



