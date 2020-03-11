<?php

include('Api.php');
include ('config.php');
include ('Database.php');

$connector = new Api('deaec2ac82e652297575798a5fe2ae92','419b766cb5eec348b93622ae65c5e27a');
$database = new Database(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$products = $connector->getAllProducts();


foreach ($products as $key => $product) {
    $product = $connector->getInfoOneProduct(
        $product['id'],
        [
            "id",
            "type",
            "name",
            "description",
            "price",
            "quantity",
            "categories_ids",
            "stores_ids",
            "url",
            "backorders",
            "manage_stock",
            "create_at",
            "modified_at",
//            "images",
        ]
    );
    if($database->createProduct($product)) {
        echo $product['id'] . ' - product is created <br>';
    } elseif($database->updateProduct($product)) {
        echo $product['id'] . ' - product is updated <br>';
    } else {
        echo $product['id'] . ' - product is not valid <br>';
    }
}

echo '<p align="center">
    <a href="index.php">Main page</a>
</p>';

