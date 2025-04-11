<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <?php require "../db.php"; require "../security.php"; ?>
</head>
<body>
    <main>
        <?php require "../includes/aside.php"; ?>
        <?php 
            function productDetails($id) {
                header("Location: "."./product-details.php?id=" . $row["id"]);
                exit();
            }
        ?>
        <section>
            <div class="items">
                <div class="controls">
                    <form action="">
                        <ion-icon name="search-outline"></ion-icon>
                        <input type="text" name="search" id="search" placeholder="...">
                    </form>
                    <button onclick><ion-icon name="list-outline"></ion-icon></button>
                    <a href="./product-details.php" class="btn add"><ion-icon name="add-outline"></ion-icon> New</a>
                </div>
                <div class="grid">

                    <?php
                        $SQL= "SELECT id, name, stock, price, img_src FROM product";

                        $res = $mysqli->query($SQL);

                        if ($res->num_rows > 0) {
                            while($row = $res->fetch_assoc()) {

                                echo "<div class='list-item'>
                                    <a href='./product-details.php?id=" . $row["id"] . "'>
                                        <img src='" . $row["img_src"] . "' />
                                        <div class='product-name'>" . $row["name"] . "</div>
                                        <div class='product-price'>" . $row["price"] . " €</div>
                                        <div class='product-stock'>". $row["stock"] . " left</div>
                                    </a>
                                    <div class='product-order'><input class='prod-quantity' type='number' name='prod-quantity' /><ion-icon onclick='addProductToCart(event,".$row["id"].")' name='bag-add-outline'></ion-icon></div>
                                </div>";
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                </div>
            </div>
        </section>
    </main>
    <script>
        function addProductToCart(event,id) {
            let quantity = event.target.parentNode.getElementsByClassName('prod-quantity')[0].value
            event.target.parentNode.childNodes[0].value = ""
            if (quantity !== "") {
                let orderProducts = JSON.parse(localStorage.getItem("orderProducts"))
                if (orderProducts === null) {
                    orderProducts = []
                    orderProducts.push({id,quantity})
                    document.cookie="cart="
                    localStorage.setItem("orderProducts",JSON.stringify(orderProducts))
                } else {
                    let index = orderProducts.findIndex((prod) => prod.id === id)
                    if (index >= 0) {
                        orderProducts[index].quantity = parseInt(orderProducts[index].quantity) + parseInt(quantity)
                        localStorage.setItem("orderProducts",JSON.stringify(orderProducts))
                    } else {
                        orderProducts.push({id,quantity})
                        localStorage.setItem("orderProducts",JSON.stringify(orderProducts))
                    }
                }
            }            
        }

    </script>
    <?php require "../includes/icons.php" ?>
</body>
</html>



