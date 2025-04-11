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

                $SQL= "SELECT id,id_client,date,description FROM invoice WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();

                $date = $row["date"];
                $idClient = $row["id_client"];
                $description = $row["description"];

                $editing = true;
            } else {
                $actionURL = './new-invoice.php';
                $date = $_POST["dnote-date"];
                $idClient = $_POST["dnote-client"];
                $ordProdId = $_POST["dnote-prodid"];
                $quantitys = $_POST["dnote-quantity"];
                $discounts = $_POST["dnote-discount"];
                $description = "";
            }

        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>Invoice details</h1>";} else {echo "<h1>New invoice</h1>";} ?>

                    <input type="hidden" name="invoice-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                
                    <label for="invoice-date">Date:</label>
                    <input id="invoice-date" name="invoice-date" type="date" placeholder="e.g. 25/10/2025" value="<?php echo $date ?>">

                    <label for="invoice-client">Client:</label>
                    <select name="invoice-client" id="invoice-client">
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

                    <label for="invoice-desc">Description and additional observations:</label>
                    <textarea name="invoice-desc" id="invoice-desc" placeholder="Paid by card, cash, ... " cols="30" rows="10"><?php echo $description ?></textarea>

                    <h2>Products</h2>

                    <table class="item-prod-list">
                        <tr><th>Id</th><th>Name</th><th>Iva</th><th>Price</th><th>Discount</th><th>Quantity</th><th>Total</th></tr>

                    <?php 

                    if ($editing) {
                        $SQL= "SELECT invoice_line.quantity,product.id,product.name,product.iva,product.price,invoice_line.discount FROM invoice_line INNER JOIN product ON invoice_line.id_product = product.id WHERE invoice_line.id_invoice = ?";

                        $stmt = $mysqli->prepare($SQL);
                        $stmt->bind_param("i",$_GET["id"]);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            while($row3 = $res->fetch_assoc()) {
                                $total = $row3["price"] * $row3["quantity"];
                                $total = $total - ($total * ($row3["discount"] / 100));
                                echo "<tr><td><input type='number' name='invoice-prodid[]' value='".$row3["id"]."' /></td><td>".$row3["name"]."</td><td>".$row3["iva"]."</td><td>".$row3["price"]."</td><td><input type='number' name='invoice-discount[]' value='".$row3["discount"]."' /></td><td><input type='number' name='invoice-quantity[]' value='".$row3["quantity"]."' /></td><td>".$total."</td></tr>";
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
                                $discount = $discounts[$index];
                                
                                $total = $row3["price"] * $quantity;
                                $total = $total - ($total * ($discount / 100));
                                echo "<tr><td><input type='number' name='invoice-prodid[]' value='".$row3["id"]."' /></td><td>".$row3["name"]."</td><td>".$row3["iva"]."</td><td>".$row3["price"]."</td><td><input type='number' name='invoice-discount[]' value='".$discount."' /></td><td><input type='number' name='invoice-quantity[]' value='".$quantity."' /></td><td>".$total."</td></tr>";
                                $index = $index + 1;
                            }
                        }
                    }

                    ?>

                </table>
                
                    <?php 
                        if ($editing) {
                            echo "<input class='update' type='submit' value='Update'>";
                            echo "<input type='submit' formaction='./print-invoice.php' value='Print PDF' /></form>";
                            echo "<form method='post' action='./delete-product.php'><input type='hidden' id='prod-id' name='prod-id' value='".$row["id"]."'><input class='remove' type='submit' value='Delete'></form>";
                        } else {
                            echo "<input type='submit' value='Create'></form>";
                        }
                    ?>
                
            </div>
        </section>
    </main>

    <?php require "../includes/icons.php" ?>
</body>
</html>