<?php

class Database
{
    private $conn;

    public function  __construct($host, $username, $passwod, $db)
    {
        $this->conn = new \mysqli(
            $host,
            $username,
            $passwod,
            $db
        );
    }

    public  function  getConnection()
    {
        return $this->conn;
    }

    public function getDataProduct($page = 0)
    {
        $limit = 5;
        $sql = 'SELECT products.productID, products.name, products.description, products.quantity, products.create_at, 
                products.price,  products.modified_at
                FROM products
                LIMIT ' . (($limit * $page) - $limit) . ', ' . $limit;

        $result = $this->conn->query($sql);
        foreach (mysqli_fetch_all($result,MYSQLI_ASSOC) as $key){
            $data[] = $key;
        }
        return $data;
    }

    public function getDataTodayProduct($page,$date)
    {
        $limit = 5;
        $sql = 'SELECT products.productID, products.name, products.description, products.quantity, products.create_at, 
                products.price,  products.modified_at
                FROM products
                WHERE create_at LIKE "' . $date . '%" 
                LIMIT ' . (($limit * $page) - $limit) . ', ' . $limit;
        $result = $this->conn->query($sql);
        foreach (mysqli_fetch_all($result,MYSQLI_ASSOC) as $key){
            $data[] = $key;
        }
        return $data;
    }

    public function createProduct(array $dataProduct)
    {
        $sql = 'INSERT INTO products (productID, name, description, categories_ids, create_at, price, `type`, quantity, backorders, manage_stock, modified_at)  ' .
            'VALUES (
            "' . $dataProduct['id'] . '", '
            . '"' . addcslashes(html_entity_decode($dataProduct['name'] ?? null),'"') . '", '
            . '"' . addcslashes(html_entity_decode($dataProduct['description'] ?? null),'"') . '", '
            . '"' .   ($dataProduct['categories_ids'] ?? 0) . '", '
            . '"' . ($dataProduct['create_at'] ?? null) . '", '
            . ($dataProduct['price'] ?? null) . ', '
            . '"' . ($dataProduct['type'] ?? null) . '", '
            . ($dataProduct['quantity'] ?? null) . ', '
            .' '. ($dataProduct['backorders'] ?? null) . ', '
            . ($dataProduct['manage_stock'] ?? null) . ', '
            .'"'. ($dataProduct['modified_at'] ?? null) . '");';
        return mysqli_query($this->conn, $sql);
    }

    public function updateProduct(array $dataProduct)
    {
        $sql = 'UPDATE products ' .
            'SET name="' . (addcslashes(html_entity_decode($dataProduct['name']),'"') . '", '
            . 'description="' . (addcslashes(html_entity_decode($dataProduct['description']),'"') ?? null) . '", '
            . 'categories_ids="' . ($dataProduct['categories_ids'] ?? null) . '", '
            . 'create_at="' . $dataProduct['create_at'] ?? null) . '", '
            . 'price=' . ($dataProduct['price'] ?? null) . ', '
            . '`type`="' . ($dataProduct['type'] ?? null) . '", '
            .'quantity='. ($dataProduct['quantity'] ?? null) . ', '
            .'manage_stock='. ($dataProduct['manage_stock'] ?? null) . ', '
            .'backorders='. ($dataProduct['backorders'] ?? null) . ', '
            .'modified_at="'. ($dataProduct['modified_at'] ?? null) . '" 
            WHERE productID = ' . ($dataProduct['id'] ?? null) ;
        return mysqli_query($this->conn, $sql);
    }

    public function getCountPage ($table) {
        return ceil(mysqli_num_rows($this->conn->query("SELECT productID FROM " . $table)) / 5);
    }


    public function getCountTodayPage ($table) {
        return ceil(mysqli_num_rows($this->conn->query('SELECT productID FROM ' . $table . ' WHERE create_at LIKE "' . date("Y-m-d") . '%"')) / 5);
    }

    public function getCountYesterdayPage ($table) {
        return ceil(mysqli_num_rows($this->conn->query('SELECT productID FROM ' . $table . ' WHERE create_at LIKE "' . date("Y-m-d",strtotime("-1 days")) . '%"')) / 5);
    }

}
