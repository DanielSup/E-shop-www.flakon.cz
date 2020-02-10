
<head>
    <meta charset="Windows-1250">
    <title></title>
</head>
<body>
    <?php
    require_once 'config.php';
    $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (isset($_GET["order"])) {
        if (isset($_GET["item"])) {
            $con = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            $query = mysqli_query($con, "SELECT " . DB_PREFIX . "order_product.order_product_id, " . DB_PREFIX . "order_product.order_id, " . DB_PREFIX . "order_product.product_id, " . DB_PREFIX . "order_product.name, " . DB_PREFIX . "order_product.model, " . DB_PREFIX . "order_product.quantity, " . DB_PREFIX . "order_product.price, " . DB_PREFIX . "order_product.total, " . DB_PREFIX . "order_product.tax, " . DB_PREFIX . "order_product.reward, " . DB_PREFIX . "product. image "
                    . "FROM " . DB_PREFIX . "order_product, " . DB_PREFIX . "product WHERE order_id = '" . $_GET["order"] . "' AND "
                    . DB_PREFIX . "order_product.product_id = " . DB_PREFIX . "product.product_id AND " . DB_PREFIX . "order_product.product_id=" . $_GET["item"]);
            echo '<table border="2">';
            foreach ($query as $row) {
                echo "<tr><td>" . $row["name"] . "</td><td><img src=\"image/".$row['image']."\" style=\"height:100px;\"></td><td>" . $row["price"] . "</td><td>" . $row["quantity"] . "</td><td>" . $row["total"] . "</td></tr>";
            }
            echo '</table>';
        } else {
            $query = mysqli_query($con, "SELECT " . DB_PREFIX . "order_product.order_product_id, " . DB_PREFIX . "order_product.order_id, " . DB_PREFIX . "order_product.product_id, " . DB_PREFIX . "order_product.name, " . DB_PREFIX . "order_product.model, " . DB_PREFIX . "order_product.quantity, " . DB_PREFIX . "order_product.price, " . DB_PREFIX . "order_product.total, " . DB_PREFIX . "order_product.tax, " . DB_PREFIX . "order_product.reward, " . DB_PREFIX . "product. image "
                    . "FROM " . DB_PREFIX . "order_product, " . DB_PREFIX . "product WHERE order_id = '" . $_GET["order"] . "' AND "
                    . DB_PREFIX . "order_product.product_id = " . DB_PREFIX . "product.product_id ");
            echo '<table border="2">';
            foreach ($query as $row) {
                echo "<tr><td>" . $row["name"] . "</td><td><img src=\"image/".$row['image']."\" style=\"height:100px;\"></td><td>" . $row["price"] . "</td><td>" . $row["quantity"] . "</td><td>" . $row["total"] . "</td></tr>";
            }
            echo '</table>';
        }
    }
    ?>
</body>
</html>

