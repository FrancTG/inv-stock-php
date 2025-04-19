<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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
                $actionURL = './update-delivery-note.php';

                $SQL= "SELECT id,id_order,id_client,date FROM delivery_note WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();

                $date = $row["date"];
                $idOrder = $row["id_order"];
                $idClient = $row["id_client"];
                $editing = true;
            } else {
                $actionURL = './new-delivery-note.php';
                $date = $_POST["ord-date"];
                $idOrder = $_POST["ord-id"];
                $idClient = $_POST["ord-client"];
                $ordProdId = $_POST["ord-prodid"];
                $quantitys = $_POST["ord-quantity"];
            }

        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>Delivery note details</h1>";} else {echo "<h1>New delivery note</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<button title='Update delivery note' class='update' type='submit'><ion-icon name='refresh-outline'></ion-icon></button>";
                                echo "<button title='Delete delivery note' class='delete' type='submit' formaction='./delete-delivery-note.php'><ion-icon name='trash-outline'></ion-icon></button>";
                                echo "<button type='submit' formaction='../invoices/invoice-details.php'>Create invoice from delivery note</button>";
                                echo "<button type='submit' formaction='./print-delivery-note.php' formtarget='_blank'>Print in PDF</button>";
                            } else {
                                echo "<button type='submit'>Create</button>";
                            }
                        ?>
                    </div>

                    <input type="hidden" name="dnote-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                
                    <label for="dnote-date">Date:</label>
                    <input id="dnote-date" name="dnote-date" type="date" placeholder="e.g. 25/10/2025" value="<?php echo $date ?>">
                
                    <label for="dnote-idorder">Order:</label>
                    <input disable type="number" name="dnote-idorder" value="<?php echo $idOrder ?>" />

                    <label for="dnote-client">Client:</label>
                    <select name="dnote-client" id="dnote-client">
                        <?php 
                            $SQL= "SELECT id,name,company FROM client";

                            $stmt = $mysqli->prepare($SQL); 
                            $stmt->execute();
                            $res = $stmt->get_result();

                            if ($res->num_rows > 0) {
                                while($row2 = $res->fetch_assoc()) {
                                    if (isset($idClient) and $idClient == $row2["id"]) {
                                        echo "<option selected value='".$row2["id"]."'>".$row2["name"]." from ".$row2["company"]."</option>";
                                    } else {
                                        echo "<option value='".$row2["id"]."'>".$row2["name"]." from ".$row2["company"]."</option>";
                                    }
                                }
                            }
                        ?>
                    </select>

                    <h2>Products</h2>

                    <table class="item-prod-list">
                        <tr><th>Id</th><th>Name</th><th>Iva</th><th>Price</th><th>Discount</th><th>Quantity</th><th>Total</th></tr>

                    <?php 

                    if ($editing) {
                        $SQL= "SELECT delivery_note_line.quantity,product.id,product.name,product.iva,product.price,delivery_note_line.discount FROM delivery_note_line INNER JOIN product ON delivery_note_line.id_product = product.id WHERE delivery_note_line.id_delivery_note = ?";

                        $stmt = $mysqli->prepare($SQL);
                        $stmt->bind_param("i",$_GET["id"]);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            // output data of each row
                            while($row3 = $res->fetch_assoc()) {
                                $total = $row3["price"] * $row3["quantity"];
                                $total = $total - ($total * ($row3["discount"] / 100));
                                echo "<tr><td><input type='number' name='dnote-prodid[]' value='".$row3["id"]."' /></td><td>".$row3["name"]."</td><td>".$row3["iva"]."</td><td>".$row3["price"]."</td><td><input type='number' name='dnote-discount[]' value='".$row3["discount"]."' /></td><td><input type='number' name='dnote-quantity[]' value='".$row3["quantity"]."' /></td><td>".$total."</td></tr>";
                            }
                        }
                    } else {
                        $SQL = "SELECT id,name,iva,price,discount FROM product WHERE id IN (";

                        for ($i = 0; $i < count($ordProdId)-1; $i++) {
                            $SQL = $SQL . $ordProdId[$i] . ",";
                        }

                        $SQL = $SQL . $ordProdId[$i] . ")";
                        $stmt = $mysqli->prepare($SQL);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            // output data of each row
                            $index = 0;
                            while($row3 = $res->fetch_assoc()) {
                                $quantity = $quantitys[$index];
                                
                                $total = $row3["price"] * $quantity;
                                $total = $total - ($total * ($row3["discount"] / 100));
                                echo "<tr><td><input type='number' name='dnote-prodid[]' value='".$row3["id"]."' /></td><td>".$row3["name"]."</td><td>".$row3["iva"]."</td><td>".$row3["price"]."</td><td><input type='number' name='dnote-discount[]' value='".$row3["discount"]."' /></td><td><input type='number' name='dnote-quantity[]' value='".$quantity."' /></td><td>".$total."</td></tr>";
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

    <?php require "../includes/icons.php" ?>
</body>
</html>