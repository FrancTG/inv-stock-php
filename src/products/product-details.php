<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
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
                $actionURL = './update-product.php';

                $SQL= "SELECT id,ean,name,stock,weight,volume,category,iva,price,discount,description,img_src FROM product WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $editing = true;
            } else {
                $actionURL = './new-product.php';
                $editing = false;
            }
        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>Detalles del producto</h1>";} else {echo "<h1>Nuevo producto</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<button title='Update product' class='update' type='submit'><ion-icon name='refresh-outline'></ion-icon></button>";
                                echo "<button title='Delete product' class='delete' type='submit' formaction='./delete-product.php'><ion-icon name='trash-outline'></ion-icon></button>";
                            } else {
                                echo "<button class='add' type='submit'>Create</button>";
                            }
                        ?>
                    </div>

                    <input type="hidden" name="prod-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                    
                    <label for="prod-img">Select image:</label>
                    <!--<input type="file" name="prod-img" id="prod-img">-->
                    <input type="text" name="prod-img" id="prod-img" value="<?php if (isset($row)) echo $row["img_src"] ?>">
                
                    <label for="prod-ean">EAN:</label>
                    <input id="prod-ean" name="prod-ean" type="text" placeholder="e.g. 978020137962" min="0" value="<?php if (isset($row)) echo $row["ean"] ?>">
                
                    <label for="prod-name">Name:</label>
                    <input type="text" name="prod-name" id="prod-name" placeholder="Patatas Fritas, Refresco Cola, ..."  value="<?php if (isset($row)) echo $row["name"] ?>"> 
                
                    <label for="prod-description">Description:</label>
                    <input type="text" name="prod-description" id="prod-description" placeholder="Al punto de sal, Light y sin Cafeina, ..."  value="<?php if (isset($row)) echo $row["description"] ?>">

                    <label for="prod-stock">Stock:</label>
                    <input type="number" name="prod-stock" id="prod-stock" placeholder="e.g. 125" min="0"  value="<?php if (isset($row)) echo $row["stock"] ?>">
                
                    <label for="prod-weight">Weight:</label>
                    <input type="number" name="prod-weight" id="prod-weight" placeholder="e.g. 2.55 (Kg)"  step=".01" min="0"  value="<?php if (isset($row)) echo $row["weight"] ?>">
                
                    <label for="prod-volume">Volume:</label>
                    <input type="number" name="prod-volume" id="prod-volume" placeholder="e.g. 0.33 (L)"  step=".01" min="0"  value="<?php if (isset($row)) echo $row["volume"] ?>">
                
                    <label for="prod-category">Category:</label>
                    <input type="text" name="prod-category" id="prod-category" placeholder="Refrescos, Patatas, ..."  value="<?php if (isset($row)) echo $row["category"] ?>">
                
                    <label for="prod-iva">IVA:</label>
                    <input type="number" name="prod-iva" id="prod-iva" placeholder="e.g. 21 (%)"  step=".01" min="0"  value="<?php if (isset($row)) echo $row["iva"] ?>">
                
                    <label for="prod-price">Price:</label>
                    <input type="number" name="prod-price" id="prod-price" placeholder ="e.g. 3.45 (€/$)" step=".01" min="0"  value="<?php if (isset($row)) echo $row["price"] ?>">
                
                    <label for="prod-discount">Discount:</label>
                    <input type="number" name="prod-discount" id="prod-discount" placeholder="e.g. 12.5 (%)"  step=".01" min="0"  value="<?php if (isset($row)) echo $row["discount"] ?>">
                </form>
            </div>
        </section>
    </main>

    <?php require "../includes/icons.php" ?>
</body>
</html>