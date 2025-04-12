<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Details</title>
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
                $actionURL = './update-supplier.php';

                $SQL= "SELECT id,name,company,address,city,country,phone_number,iban,img_src FROM supplier WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $editing = true;
            } else {
                $actionURL = './new-supplier.php';
                $editing = false;
            }
        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>Supplier details</h1>";} else {echo "<h1>New supplier</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<input type='submit' value='Update' />";
                                echo "<input type='submit' fromaction='./delete-supplier.php' value='Delete' />";
                            } else {
                                echo "<input type='submit' value='Create' />";
                            }
                        ?>
                    </div>

                    <input type="hidden" name="supp-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                    
                    <label for="supp-img">Select image:</label>
                    <!--<input type="file" name="supp-img" id="supp-img">-->
                    <input type="text" name="supp-img" id="supp-img" value="<?php if (isset($row)) echo $row["img_src"] ?>">
                
                    <label for="supp-name">Name:</label>
                    <input id="supp-name" name="supp-name" type="text" placeholder="e.g. John Marston" value="<?php if (isset($row)) echo $row["name"] ?>">
                
                    <label for="supp-company">Company:</label>
                    <input type="text" name="supp-company" id="supp-company" placeholder="e.g. Example S.L." value="<?php if (isset($row)) echo $row["company"] ?>"> 
                
                    <label for="supp-address">Address:</label>
                    <input type="text" name="supp-address" id="supp-address" placeholder="e.g. 412 Example Street" value="<?php if (isset($row)) echo $row["address"] ?>">
                
                    <label for="supp-city">City:</label>
                    <input type="text" name="supp-city" id="supp-city" placeholder="e.g. Barcelona" value="<?php if (isset($row)) echo $row["city"] ?>">
                
                    <label for="supp-country">Country:</label>
                    <input type="text" name="supp-country" id="supp-country" placeholder="e.g. Spain" value="<?php if (isset($row)) echo $row["country"] ?>">
                
                    <label for="supp-phone">Phone Number:</label>
                    <input type="text" name="supp-phone" id="supp-phone" placeholder="e.g. 636777888"  value="<?php if (isset($row)) echo $row["phone_number"] ?>">
                
                    <label for="supp-iban">IBAN:</label>
                    <input type="text" name="supp-iban" id="supp-iban" placeholder="e.g. ES7921000813610123456789" value="<?php if (isset($row)) echo $row["iban"] ?>">
        
                </from>
            </div>
        </section>
    </main>
    <?php require "../includes/icons.php" ?>
</body>
</html>