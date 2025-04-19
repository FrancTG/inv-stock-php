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

            $actionURL = "";
            $editing = false;

            if (isset($_GET["id"])) {
                $actionURL = './update-purchase.php';

                $SQL= "SELECT id,id_supplier,date FROM purchase  WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $editing = true;
            } else {
                $actionURL = './new-purchase.php';
                $prodIds = $_POST["ord-prodid"];
                $quantitys = $_POST["ord-quantity"];
                $editing = false;
            }
        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>Purchase details</h1>";} else {echo "<h1>New purchase</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<button title='Update client' class='update' type='submit'><ion-icon name='refresh-outline'></ion-icon></button>";
                                echo "<button title='Delete client' class='delete' type='submit' formaction='./delete-purchase.php'><ion-icon name='trash-outline'></ion-icon></button>";
                            } else {
                                echo "<input class='add' type='submit' value='Create' />";
                            }
                        ?>
                    </div>

                    <input type="hidden" name="pur-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                
                    <label for="pur-date">Date:</label>
                    <input type="date" name="pur-date" id="pur-date"  value="<?php if (isset($row)) echo $row["date"] ?>">

                    <label for="pur-supplier">Supplier:</label>
                    <select name="pur-supplier" id="pur-supplier">
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
                        <tr><th>Id</th><th>Name</th><th>Quantity</th><th>Purchased Price</th><th>Profit (%)</th><th>Custom Price</th><th>Total</th></tr>

                    <?php 

                    if ($editing) {
                        $SQL= "SELECT product.id,product.name,purchase_line.quantity,purchase_line.buy_price,purchase_line.profit,purchase_line.custom_price FROM purchase_line INNER JOIN product ON purchase_line.id_product = product.id WHERE purchase_line.id_purchase = ?";

                        $stmt = $mysqli->prepare($SQL);
                        $stmt->bind_param("i",$_GET["id"]);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        if ($res->num_rows > 0) {
                            while($row3 = $res->fetch_assoc()) {
                                $total = $row3["buy_price"] * $row3["quantity"];
                                echo "<tr><td><input type='number' name='pur-prodid[]' value='".$row3["id"]."' /></td>
                                <td>".$row3["name"]."</td>
                                <td><input type='number' name='pur-quantity[]' value='".$row3["quantity"]."' /></td>
                                <td><input type='number' step='.01' min='0' name='pur-buyprice[]' value='".$row3["buy_price"]."' /></td>
                                <td><input type='number' step='.01' min='0' name='pur-profit[]' value='".$row3["profit"]."' /></td>
                                <td><input type='number' step='.01' min='0' name='pur-cprice[]' value='".$row3["custom_price"]."' /></td>
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
                                echo "<tr><td><input type='number' name='pur-prodid[]' value='".$row3["id"]."' /></td>
                                <td>".$row3["name"]."</td>
                                <td><input type='number' step='.01' min='0' name='pur-quantity[]' value='". $quantitys[$index] . "' /></td>
                                <td><input type='number' step='.01' min='0' name='pur-buyprice[]' /></td>
                                <td><input type='number' step='.01' min='0' name='pur-profit[]' /></td>
                                <td><input type='number' step='.01' min='0' name='pur-cprice[]' /></td>
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