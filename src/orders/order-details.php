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
                $actionURL = './update-order.php';

                $SQL= "SELECT id,id_client,date FROM orders WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $editing = true;
            } elseif (isset($_GET["cart"])){
                $actionURL = './new-order.php';
                $cartItems = json_decode($_GET["cart"],true);
            }

        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>Order details</h1>";} else {echo "<h1>New order</h1>";} ?>

                    <input type="hidden" name="ord-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                
                    <label for="ord-date">Date:</label>
                    <input id="ord-date" name="ord-date" type="date" placeholder="e.g. 25/10/2025" value="<?php if (isset($row)) echo $row["date"] ?>">
                
                    <label for="ord-client">Client:</label>
                    <select name="ord-client" id="ord-client">
                        <?php 
                            $SQL= "SELECT id,name,company FROM client";

                            $stmt = $mysqli->prepare($SQL); 
                            $stmt->execute();
                            $res = $stmt->get_result();

                            if ($res->num_rows > 0) {
                                while($row2 = $res->fetch_assoc()) {
                                    if (isset($row["id_client"]) and $row["id_client"] == $row2["id"]) {
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
                        $SQL= "SELECT order_line.quantity,product.id,product.name,product.iva,product.price,product.discount FROM order_line INNER JOIN product ON order_line.id_product = product.id WHERE order_line.id_order = ?";

                        $stmt = $mysqli->prepare($SQL);
                        $stmt->bind_param("i",$_GET["id"]);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            // output data of each row
                            while($row3 = $res->fetch_assoc()) {
                                $total = $row3["price"] * $row3["quantity"];
                                $total = $total - ($total * ($row3["discount"] / 100));
                                echo "<tr><td><input type='number' name='ord-prodid[]' value='".$row3["id"]."' /></td><td>".$row3["name"]."</td><td>".$row3["iva"]."</td><td>".$row3["price"]."</td><td>".$row3["discount"]."</td><td><input type='number' name='ord-quantity[]' value='".$row3["quantity"]."' /></td><td>".$total."</td></tr>";
                            }
                        }
                    } else {
                        $SQL = "SELECT id,name,iva,price,discount FROM product WHERE id IN (";

                        for ($i = 0; $i < count($cartItems)-1; $i++) {
                            $SQL = $SQL . $cartItems[$i]["id"] . ",";
                        }

                        $SQL = $SQL . $cartItems[$i]["id"] . ")";
                        $stmt = $mysqli->prepare($SQL);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            $index = 0;
                            while($row3 = $res->fetch_assoc()) {
                                $quantity = $cartItems[$index]["quantity"];
                                
                                $total = $row3["price"] * $quantity;
                                $total = $total - ($total * ($row3["discount"] / 100));
                                echo "<tr><td><input type='number' name='ord-prodid[]' value='".$row3["id"]."' /></td><td>".$row3["name"]."</td><td>".$row3["iva"]."</td><td>".$row3["price"]."</td><td>".$row3["discount"]."</td><td><input type='number' name='ord-quantity[]' value='".$quantity."' /></td><td>".$total."</td></tr>";
                                $index = $index + 1;
                            }
                        }
                    }

                    ?>

                </table>
                
                    <?php 
                        if ($editing) {
                            echo "<input class='update' type='submit' value='Update'>";
                            echo "<input type='submit' formaction='../delivery-notes/delivery-note-details.php' value='New delivery note from order'></form>";
                            echo "<form method='post' action='./delete-order.php'><input type='hidden' id='prod-id' name='prod-id' value='".$row["id"]."'><input class='remove' type='submit' value='Delete'></form>";
                            
                        } else {
                            echo "<input type='submit' value='Añadir pedido' />";
                            echo "<input type='submit' formaction='../invoices/invoice-details.php' value='Nueva factura' /></form>";
                        }
                    ?>
                
            </div>
        </section>
    </main>

    <?php require "../includes/icons.php" ?>
</body>
</html>