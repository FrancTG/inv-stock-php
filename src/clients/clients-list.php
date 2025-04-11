<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <?php require "../db.php"; require "../security.php"; ?>
</head>
<body>
    <main>
        <?php require "../includes/aside.php"; ?>
        <section>
            <div class="controls">
                <form action="">
                    <ion-icon name="search-outline"></ion-icon>
                    <input type="text" name="search" id="search" placeholder="...">
                </form>
                <a href="./client-details.php" class="btn-add"><ion-icon name="add-outline"></ion-icon> New</a>
            </div>
            <div class="grid">

                <?php
                    $SQL= "SELECT id,name,company,phone_number, img_src FROM client";

                    $res = $mysqli->query($SQL);

                    if ($res->num_rows > 0) {
                        // output data of each row
                        while($row = $res->fetch_assoc()) {

                            echo "<a class='list-item' href='./client-details.php?id=" . $row["id"] . "'>
                                <img class='item-img' src='" . $row["img_src"] . "'>
                                <div class='cli-name'>" . $row["name"] . "</div>
                                <div class='cli-company'>". $row["company"] . "</div>
                                <div class='cli-phone-num'>". $row["phone_number"] . "</div>
                            </a>";
                        }
                    } else {
                        echo "0 results";
                    }
                ?>
            </div>
        </section>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>



