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
                    <a href="./product-details.php" class="btn add"><ion-icon name="add-outline"></ion-icon> New</a>
                </div>
                <div class="grid"></div>
            </div>
        </section>
    </main>
    <script>
        let input = document.getElementById('search');
        mostrarProductos(input.value)
        input.addEventListener('input',() => {
            mostrarProductos(input.value)
        })

        function leerDatos(){
            if (oXML.readyState == 4) {
                let xml = oXML.responseXML;
                let tabla = document.getElementsByClassName('grid')[0];
                let definicion_tabla = new String("");
                let v;
                let item;
                
                for (i = 0; i < xml.getElementsByTagName('product').length; i++){
                    definicion_tabla = definicion_tabla + "<div class='list-item'>";
                    item = xml.getElementsByTagName('product')[i];

                    v = item.getElementsByTagName('id')[0].firstChild.data;
                    let id = v;
                    definicion_tabla = definicion_tabla+"<a href='./product-details.php?id=" + v + "'>";

                    v = item.getElementsByTagName('img')[0].firstChild.data;
                    definicion_tabla = definicion_tabla+"<img src='" + v + "' />";

                    v = item.getElementsByTagName('name')[0].firstChild.data;
                    definicion_tabla = definicion_tabla + "<div class='product-name'>" + v + "</div>";

                    v = item.getElementsByTagName('price')[0].firstChild.data;
                    definicion_tabla = definicion_tabla + "<div class='product-price'>" + v + " €</div>";

                    v = item.getElementsByTagName('stock')[0].firstChild.data;
                    definicion_tabla = definicion_tabla + "<div class='product-stock'>" + v + " left</div></a>";

                    definicion_tabla = definicion_tabla + "<div class='product-order'><input class='prod-quantity' type='number' name='prod-quantity' /><ion-icon title='Add to cart' onclick='addProductToCart(event,"+id+")' name='bag-add-outline'></ion-icon></div>";

                    definicion_tabla = definicion_tabla+"</div>";
                }
                tabla.innerHTML = definicion_tabla; 
            }
        }


        function mostrarProductos(name) {
            oXML = new XMLHttpRequest();
            oXML.open('POST', 'get-products.php');
            oXML.responseType = "document";
            oXML.overrideMimeType("application/xml");
            oXML.onreadystatechange = leerDatos;

            oXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oXML.send('name=' + name);
        }


        function addProductToCart(event,id) {
            let quantity = event.target.parentNode.getElementsByClassName('prod-quantity')[0].value
            event.target.parentNode.childNodes[0].value = ""
            if (quantity !== "") {
                let orderProducts = JSON.parse(localStorage.getItem("orderProducts"))
                if (orderProducts === null) {
                    orderProducts = []
                    orderProducts.push({id,quantity})
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



