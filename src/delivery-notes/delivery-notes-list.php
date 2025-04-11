<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Notes List</title>
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
            </div>
            <div class="list">
                <?php
                    $SQL= "SELECT delivery_note.id,delivery_note.date,client.company,client.name FROM delivery_note INNER JOIN client ON delivery_note.id_client = client.id";

                    $res = $mysqli->query($SQL);

                    if ($res->num_rows > 0) {
                        // output data of each row
                        while($row = $res->fetch_assoc()) {
                            echo "<div class='list-item'>
                            <input type='hidden' name='dnote-id[]' value='".$row["id"]."' />
                            <a href='./delivery-note-details.php?id=" . $row["id"] . "'>
                                <div class='dnote-ref'>P-" . $row["id"] . "/" . $row["date"] . "</div>
                                <div class='dnote-company'>".$row["name"] ." from ". $row["company"] . "</div>
                                <div class='dnote-total'>Total 100 €</div>
                            </a></div>";
                        }
                    } else {
                        echo "0 results";
                    }
                ?>
            </div>
        </section>
    </main>

    <?php require "../includes/icons.php" ?>
</body>
</html>



