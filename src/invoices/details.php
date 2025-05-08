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

            $editing = false;

            if (isset($_GET["id"])) {

                $SQL= "SELECT id,id_client,date,description FROM document WHERE id=?";

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
                if (isset($_POST["date"])) {
                    $date = $_POST["date"];
                } else {
                    $date = '';
                }

                if (isset($_POST["idclient"])) {
                    $idClient = $_POST["client"];
                } else {
                    $idClient = '';
                }

                if (isset($_POST["discount"])) {
                    $discounts = $_POST["discount"];
                }
                $ordProdId = $_POST["prodid"];
                $quantitys = $_POST["quantity"];                
                $description = "";
            }

        ?>
        <section>
            <div class="item-details">
                <form class="container" method="post">
                    <?php if ($editing) {echo "<h1>Invoice details</h1>";} else {echo "<h1>New invoice</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<button title='Update invoice' class='update' type='submit' formaction='./update-invoice.php'><ion-icon name='refresh-outline'></ion-icon></button>";
                                echo "<button title='Delete invoice' class='delete' type='submit' formaction='./delete-invoice.php'><ion-icon name='trash-outline'></ion-icon></button>";
                                echo "<button type='submit' formaction='./print-invoice.php' formtarget='_blank'>Print in PDF</button>";
                            } else {
                                echo "<button class='add' type='submit' formaction='./new-invoice.php'>Create</button>";
                            }
                        ?>
                    </div>


                    <input type="hidden" name="id" value="<?php if (isset($row)) echo $row["id"] ?>">
                
                    <label for="date">Date:</label>
                    <input id="date" name="date" type="date" placeholder="e.g. 25/10/2025" value="<?php echo $date ?>">

                    <label for="client">Client:</label>
                    <select name="client" id="client">
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

                    <label for="desc">Description and additional observations:</label>
                    <textarea name="desc" id="desc" placeholder="Paid by card, cash, ... " cols="30" rows="10"><?php echo $description ?></textarea>

                    <h2>Products</h2>

                    <table class="item-prod-list">
                        <tr><th>Id</th><th>Name</th><th>Iva</th><th>Price</th><th>Discount</th><th>Quantity</th><th>Total</th></tr>

                    <?php 

                    if ($editing) {
                        $SQL= "SELECT document_line.quantity,product.id,product.name,product.iva,product.price,document_line.discount FROM document_line INNER JOIN product ON document_line.id_product = product.id WHERE document_line.id_doc = ?";

                        $stmt = $mysqli->prepare($SQL);
                        $stmt->bind_param("i",$_GET["id"]);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            while($row3 = $res->fetch_assoc()) {
                                $total = $row3["price"] * $row3["quantity"];
                                $total = $total - ($total * ($row3["discount"] / 100));
                                echo "<tr><td><input type='number' name='prodid[]' value='".$row3["id"]."' /></td><td>".$row3["name"]."</td><td>".$row3["iva"]."</td><td>".$row3["price"]."</td><td><input type='number' name='discount[]' value='".$row3["discount"]."' /></td><td><input type='number' name='quantity[]' value='".$row3["quantity"]."' /></td><td>".$total."</td></tr>";
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
                                if (isset($discounts)) {
                                    $discount = $discounts[$index];
                                } else {
                                    $discount = $row3["discount"];
                                }
                                
                                $total = $row3["price"] * $quantity;
                                $total = $total - ($total * ($discount / 100));
                                echo "<tr>
                                <td><input type='number' name='prodid[]' value='".$row3["id"]."' /></td>
                                <td>".$row3["name"]."</td><td>".$row3["iva"]."</td>
                                <td>".$row3["price"]."</td><td><input type='number' name='discount[]' value='".$discount."' /></td>
                                <td><input type='number' name='quantity[]' value='".$quantity."' /></td><td>".$total."</td>
                                <td><button type='button' onclick='deleteProduct(event)' >X</button></td>
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

    <script>
        function deleteProduct(event) {
            event.target.parentNode.parentNode.remove()
        }
    </script>

    <?php require "../includes/icons.php" ?>
</body>
</html>