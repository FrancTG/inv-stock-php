<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <?php require "../security.php"; ?>
</head>
<body>
    <main>
        <?php require "../includes/aside.php"; ?>
        <section>
            <label for="cashier-input">Scan EAN code or input the product name</label>
            <input name='cashier-input' id='cashier-input' type="text" placeholder='EAN 0799439112766, Drinks, Cola Light, ...'>
            <div class="grid">

            </div>
        </section>
    </main>
    <?php require "../includes/icons.php"; ?>
    <script>
        let cashierInput = document.getElementById('cashier-input');
        cashierInput.addEventListener('input',() => {
            mostrarProductos(cashierInput.value)
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
                    definicion_tabla = definicion_tabla+"<a href='./product-details.php?id=" + v + "'>";

                    v = item.getElementsByTagName('img')[0].firstChild.data;
                    definicion_tabla = definicion_tabla+"<img src='" + v + "' />";

                    v = item.getElementsByTagName('name')[0].firstChild.data;
                    definicion_tabla = definicion_tabla + "<div class='product-name'>" + v + "</div>";

                    v = item.getElementsByTagName('price')[0].firstChild.data;
                    definicion_tabla = definicion_tabla + "<div class='product-price'>" + v + " €</div>";

                    v = item.getElementsByTagName('stock')[0].firstChild.data;
                    definicion_tabla = definicion_tabla+"<div class='product-stock'>" + v + " left</div>";

                    definicion_tabla = definicion_tabla+"</a></div>";
                }
                tabla.innerHTML = definicion_tabla; 
            }
        }

        function mostrarProductos(ean) {
            oXML = new XMLHttpRequest();
            oXML.open('POST', 'cashier-products.php');
            oXML.responseType = "document";
            oXML.overrideMimeType("application/xml");
            oXML.onreadystatechange = leerDatos;

            oXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            oXML.send('ean=' + ean);
        }
    </script>
</body>
</html>