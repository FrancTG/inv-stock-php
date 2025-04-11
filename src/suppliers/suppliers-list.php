<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers</title>
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
                    <a href="./supplier-details.php" class="btn add"><ion-icon name="add-outline"></ion-icon> New</a>
                </div>
                <div class="grid">

                    <?php
                        $SQL= "SELECT id,name,company,phone_number,img_src FROM supplier";

                        $res = $mysqli->query($SQL);

                        if ($res->num_rows > 0) {
                            while($row = $res->fetch_assoc()) {
                                echo "<a class='list-item' href='./supplier-details.php?id=" . $row["id"] . "'>
                                    <img class='item-img' src='" . $row["img_src"] . "'>
                                    <div class='supp-name'>" . $row["name"] . "</div>
                                    <div class='supp-company'>". $row["company"] . "</div>
                                    <div class='supp-phone'>" . $row["phone_number"] . "</div>
                                </a>";
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <?php require "../includes/icons.php" ?>
</body>
</html>



