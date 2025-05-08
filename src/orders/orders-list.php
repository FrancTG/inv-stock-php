<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <?php require "../db.php"; require "../security.php"; ?>
</head>
<body>
    <main>
        <?php require "../includes/aside.php"; ?>
        <section>
            <div class="controls">
                <form action="">
                    <ion-icon name="search-outline"></ion-icon>
                    <input type="text" name="search" id="search" placeholder="...">
                </form>
            </div>
            <div id='document-container' class="list"></div>
        </section>
    </main>

    <script src="../../assets/js/scripts.js"></script>
    <script>
        showDocuments('order','')
        let input = document.getElementById('search');
        input.addEventListener('input', () => {
            showDocuments('order',input.value);
        })
    </script>

    <?php require "../includes/icons.php" ?>
</body>
</html>



