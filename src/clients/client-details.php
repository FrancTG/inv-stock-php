<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client details</title>
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
                $actionURL = './update-client.php';

                $SQL= "SELECT id,identification_number,name,company,address,city,country,phone_number,img_src FROM client WHERE id=?";

                $stmt = $mysqli->prepare($SQL);
                $stmt->bind_param("i",$_GET["id"]);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $editing = true;
            } else {
                $actionURL = './new-client.php';
                $editing = false;
            }
        ?>
        <section>
            <div class="item-details">
                <form class="container" action="<?php echo $actionURL; ?>" method="post">
                    <?php if ($editing) {echo "<h1>Client details</h1>";} else {echo "<h1>New client</h1>";} ?>

                    <div class="form-buttons">
                        <?php 
                            if ($editing) {
                                echo "<button title='Update client' class='update' type='submit'><ion-icon name='refresh-outline'></ion-icon></button>";
                                echo "<button title='Delete client' class='delete' type='submit' formaction='./delete-client.php'><ion-icon name='trash-outline'></ion-icon></button>";
                            } else {
                                echo "<input class='add' type='submit' value='Create' />";
                            }
                        ?>
                    </div>

                    <input type="hidden" name="cli-id" value="<?php if (isset($row)) echo $row["id"] ?>">
                    
                    <label for="cli-img">Select image:</label>
                    <!--<input type="file" name="cli-img" id="cli-img">-->
                    <input type="text" name="cli-img" id="cli-img" value="<?php if (isset($row)) echo $row["img_src"] ?>">
                
                    <label for="cli-id-num">Identification Number:</label>
                    <input id="cli-id-num" name="cli-id-num" type="text" placeholder="e.g. 12345678S" value="<?php if (isset($row)) echo $row["identification_number"] ?>">
                
                    <label for="cli-name">Name:</label>
                    <input type="text" name="cli-name" id="cli-name" placeholder="Salted Chips, Cola Light, ..."  value="<?php if (isset($row)) echo $row["name"] ?>"> 
                
                    <label for="cli-company">Company:</label>
                    <input type="text" name="cli-company" id="cli-company" placeholder="e.g. My Company S.L" value="<?php if (isset($row)) echo $row["company"] ?>">
                
                    <label for="cli-address">Address:</label>
                    <input type="text" name="cli-address" id="cli-address" placeholder="e.g. 412 Example Street" value="<?php if (isset($row)) echo $row["address"] ?>">
                
                    <label for="cli-city">City:</label>
                    <input type="text" name="cli-city" id="cli-city" placeholder="e.g. Barcelona" value="<?php if (isset($row)) echo $row["city"] ?>">
                
                    <label for="cli-country">Country:</label>
                    <input type="text" name="cli-country" id="cli-country" placeholder="Spain, France, ..."  value="<?php if (isset($row)) echo $row["country"] ?>">
                
                    <label for="cli-phone-num">Phone Number:</label>
                    <input type="text" name="cli-phone-num" id="cli-phone-num" placeholder="e.g. 636888999" value="<?php if (isset($row)) echo $row["phone_number"] ?>">

                    
                </form>
                
            </div>
        </section>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>