<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchases</title>
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
                </div>
                <div id='document-container' class="list">

                    <?php
                        /*$SQL= "SELECT document.id,document.date,supplier.name,supplier.company FROM document INNER JOIN supplier ON supplier.id = document.id_supplier WHERE docType='purchase'";

                        $res = $mysqli->query($SQL);

                        if ($res->num_rows > 0) {
                            // output data of each row
                            while($row = $res->fetch_assoc()) {
                                echo "<div class='list-item'>
                                <input type='hidden' name='id[]' value='".$row["id"]."' />
                                <a class='list-item' href='./purchase-details.php?id=" . $row["id"] . "'>
                                    <div>" . $row["id"] . "</div>
                                    <div>" . $row["date"] . "</div>
                                    <div>". $row["name"] . ", " . $row["company"]  . "</div>
                                </a></div>";
                            }
                        } else {
                            echo "0 results";
                        }*/
                    ?>
                </div>
            </div>
        </section>
    </main>

    <script src="../../assets/js/scripts.js"></script>
    <script>
        showDocuments('purchase','')
        let input = document.getElementById('search');
        input.addEventListener('input', () => {
            showDocuments('purchase',input.value);
        })
    </script>

    <?php require "../includes/icons.php" ?>
</body>
</html>



