<span>Products</span>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">№</th>
            <th scope="col">Name</th>
            <th scope="col">Cost</th>
            <th scope="col">Quantity</th>
            <th scope="col">Sku</th>
            <th scope="col">Description</th>
            <th scope="col">Category</th>
        </tr>
    </thead>
    <?php
    foreach ($data['products'] as $key => $row): ; ?><tr>
            <td><?= $row['productID'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= html_entity_decode($row['description']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['create_at'] ?></td>
        <td><?= $row['modified_at'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<p align="center">
    <a href="index.php?<?php echo http_build_query(['page' => $data['page']-1,'filter' => $_GET['filter'] ?? 'All'])?>">Prev page</a>
    <span> --- <?= $data['page'] ?> --- </span>
    <a href="index.php?<?php echo http_build_query(['page' => $data['page']+1,'filter' => $_GET['filter'] ?? 'All'])?>">Next page</a>
</p>

<p align="center">
    <a href="index.php?<?php echo http_build_query(['filter' => 'Today','page' => $_GET['page'] ?? 1])?>">Today</a>
    <span> --- </span>
    <a href="index.php?<?php echo http_build_query(['filter' => 'Yesterday','page' => $_GET['page'] ?? 1])?>">Yesterday</a>
    <span> --- </span>
    <a href="index.php?<?php echo http_build_query(['filter' => 'All','page' => $_GET['page'] ?? 1])?>">All</a>
</p>

<p align="center">
    <a href="getAllProduct.php">Update all product</a>
</p>

<?php
if(!empty($data['errors'])) :
    foreach ($data['errors'] as $key => $value) : ?>
        <span><?= ucfirst($key+1) ?> - <?= $value; ?></span><br>
    <?php endforeach;
endif;
?>