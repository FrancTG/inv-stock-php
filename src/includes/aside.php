<aside>
    <div class="logged-account">
        <img width="80" src="" alt="">
        <svg width="60" xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg>
        <div class="user-name">Admin</div>
        <a class="logout" href="./logout.php">Logout</a>
    </div>
    <div class="cart-info">
        <div onclick="viewOrder()" id='cart-items-link' href=""><ion-icon name="cart-outline"></ion-icon>Pedido<span id='cart-items-num'>6</span></div>
    </div>
    <nav>
        <ul>
            <li><a href="/inv-stock-php/src/home.php"><ion-icon name="home"></ion-icon>Home</a></li>
            <li><a href="/inv-stock-php/src/cashier-sales/cashier-sales.php"><ion-icon name="keypad"></ion-icon>Cashier Sale</a></li>
            <li><a href="/inv-stock-php/src/products/products-list.php"><ion-icon name="fast-food"></ion-icon>Products</a></li>
            <li><a href="/inv-stock-php/src/orders/orders-list.php"><ion-icon name="layers"></ion-icon>Orders</a></li>
            <li><a href="/inv-stock-php/src/delivery-notes/delivery-notes-list.php"><ion-icon name="document-text"></ion-icon>Delivery Notes</a></li>
            <li><a href="/inv-stock-php/src/invoices/invoices-list.php"><ion-icon name="document-text"></ion-icon>Invoices</a></li>
            <li><a href="/inv-stock-php/src/clients/clients-list.php"><ion-icon name="people"></ion-icon>Clients</a></li>
            <li><a href="/inv-stock-php/src/suppliers/suppliers-list.php"><ion-icon name="people"></ion-icon>Suppliers</a></li>
        </ul>
    </nav>
    <div></div>
    <script>
        let orderProducts = JSON.parse(localStorage.getItem("orderProducts"))
        document.getElementById('cart-items-num').innerHTML = orderProducts?.length || 0

        function viewOrder() {
            location.href = "/inv-stock-php/src/orders/order-details.php?cart="+localStorage.getItem("orderProducts")
        }
    </script>
</aside>