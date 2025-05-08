<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase details</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <?php require "../db.php"; require "../security.php";?>
</head>
<body>
    <main>
        <?php
            require "../includes/aside.php";

            $editing = false;

            if (isset($_GET["id"])) {

                $SQL= "SELECT id,id_supplier,date FROM document WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $editing = true;
            } else {
                $prodIds = $_POST["prodid"];
                $quantitys = $_POST["quantity"];
                $editing = false;
            }
        ?>
        <section>
            <div class="item-details">
                <form class="container" method="post">
                    <?php if ($editing) {echo "<h1>Purchase details</h1>";} else {echo "<h1>New purchase</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<button title='Update client' class='update' type='submit' formaction='./update-purchase.php'><ion-icon name='refresh-outline'></ion-icon></button>";
                                echo "<button title='Delete client' class='delete' type='submit' formaction='./delete-purchase.php'><ion-icon name='trash-outline'></ion-icon></button>";
                            } else {
                                echo "<input class='add' type='submit' value='Create' formaction='./new-purchase.php' />";
                            }
                        ?>
                    </div>

                    <input type="hidden" name="id" value="<?php if (isset($row)) echo $row["id"] ?>">
                
                    <label for="date">Date:</label>
                    <input type="date" name="date" id="date"  value="<?php if (isset($row)) echo $row["date"] ?>">

                    <label for="supplier">Supplier:</label>
                    <select name="supplier" id="supplier">
                        <?php 
                            $SQL= "SELECT id,name,company FROM supplier";

                            $stmt = $mysqli->prepare($SQL); 
                            $stmt->execute();
                            $res = $stmt->get_result();

                            if ($res->num_rows > 0) {
                                while($row2 = $res->fetch_assoc()) {
                                    if (isset($row["id_supplier"]) and $row["id_supplier"] == $row2["id"]) {
                                        echo "<option selected value='".$row2["id"]."'>".$row2["name"]." from ".$row2["company"]."</option>";
                                    } else {
                                        echo "<option value='".$row2["id"]."'>".$row2["name"]." from ".$row2["company"]."</option>";
                                    }
                                }
                            }
                        ?>
                    </select>
                
                    <table class="item-prod-list">
                        <tr><th>Id</th><th>Name</th><th>Quantity</th><th>Custom Price</th><th></th></tr>

                    <?php 

                    if ($editing) {
                        $SQL= "SELECT product.id,product.name,document_line.quantity,document_line.custom_price FROM document_line INNER JOIN product ON document_line.id_product = product.id WHERE document_line.id_doc = ?";

                        $stmt = $mysqli->prepare($SQL);
                        $stmt->bind_param("i",$_GET["id"]);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            while($row3 = $res->fetch_assoc()) {
                                $total = $row3["custom_price"] * $row3["quantity"];
                                echo "<tr>
                                <td><input type='number' name='prodid[]' value='".$row3["id"]."' /></td>
                                <td>".$row3["name"]."</td>
                                <td><input type='number' name='quantity[]' value='".$row3["quantity"]."' /></td>
                                <td><input type='number' step='.01' min='0' name='cprice[]' value='".$row3["custom_price"]."' /></td>
                                <td>".$total."</td>
                                </tr>";
                            }
                        }
                    } else {
                        $SQL = "SELECT id,name,price FROM product WHERE id IN (";

                        for ($i = 0; $i < count($prodIds)-1; $i++) {
                            $SQL = $SQL . $prodIds[$i] . ",";
                        }

                        $SQL = $SQL . $prodIds[$i] . ")";
                        $stmt = $mysqli->prepare($SQL);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            $index = 0;
                            while($row3 = $res->fetch_assoc()) {
                                echo "<tr><td><input type='number' name='prodid[]' value='".$row3["id"]."' /></td>
                                <td>".$row3["name"]."</td>
                                <td><input type='number' step='.01' min='0' name='quantity[]' value='". $quantitys[$index] . "' /></td>
                                <td><input type='number' step='.01' min='0' name='cprice[]' /></td>
                                <td></td>
                                </tr>";
                                $index = $index + 1;
                            }
                        }
                    }
                    ?>
                    </table>
                    
                </form>
                
            </div>
        </section>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>