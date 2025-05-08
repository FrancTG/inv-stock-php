<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <?php require "db.php"; require "security.php";?>
</head>
<body>
    <main>
        <?php
            require "./includes/aside.php";

            $cartItems = null;
            if (isset($_GET["cart"])){
                $actionURL = './new-order.php';
                $cartItems = json_decode($_GET["cart"],true);
            }

        ?>
        <section>
            <div class="item-details">
                <form class="container" method="post">
                    <h1>Cart Items</h1>

                    <div class="form-buttons">
                        <button type='submit' formaction='./orders/details.php'>New Order</button>
                        <button type='submit' formaction='./invoices/details.php'>New Invoice</button>
                        <button type='submit' formaction='./purchases/details.php'>New purchase from items</button>
                    </div>

                    <table class="item-prod-list">
                        <tr><th>Id</th><th>Name</th><th>Iva</th><th>Price</th><th>Discount</th><th>Quantity</th><th>Total</th><th></th></tr>

                    <?php 

                    if ($cartItems) {
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
                            while($row = $res->fetch_assoc()) {
                                $quantity = $cartItems[$index]["quantity"];
                                
                                $total = $row["price"] * $quantity;
                                $total = $total - ($total * ($row["discount"] / 100));
                                echo "<tr><td><input type='number' name='prodid[]' value='".$row["id"]."' /></td><td>".$row["name"]."</td><td>".$row["iva"]."</td><td>".$row["price"]."</td><td>".$row["discount"]."</td><td><input type='number' name='quantity[]' value='".$quantity."' /></td><td>".$total."</td><td><button type='button' onclick='removeItemFromCart(event,".$row["id"].")'>X</button></td></tr>";
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
        function removeItemFromCart(event,id) {
            event.target.parentNode.parentNode.remove()
            let orderProducts = JSON.parse(localStorage.getItem("orderProducts"))
            let index = orderProducts.findIndex((prod) => prod.id === id)
            console.log(index)
            orderProducts.splice(index,1)
            console.log(orderProducts)
            localStorage.setItem("orderProducts",JSON.stringify(orderProducts))
        }
    </script>

    <?php require "./includes/icons.php" ?>
</body>
</html>