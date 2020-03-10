<?php

include ('View.php');
include ('Database.php');
include ('config.php');

$database = new Database(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$view = new View;

if ($_GET['filter'] === 'Today') {
    if($database->getCountTodayPage('products') == 0){
        $view->generate(
            'errors_template.php',
            'template_view.php',
            [
                'errors' => ['Not found product with this params']
            ]
        );
    } elseif (intval($_GET['page']) < 1 || intval($_GET['page'] > $database->getCountTodayPage('products'))) {
        unset($_GET['page']);
        header("Location: index.php?filter=Today&page=1");
    } else {
        $view->generate(
            'products_template.php',
            'template_view.php',
            [
                'products' => $database->getDataTodayProduct($_GET['page'] ?? 1, date("Y-m-d")),
                'page' => $_GET['page'] ?? 1
            ]
        );
    }
} elseif ($_GET['filter'] === 'Yesterday') {
    if($database->getCountYesterdayPage('products') == 0) {
        $view->generate(
            'errors_template.php',
            'template_view.php',
            [
                'errors' => ['Not found product with this params']
            ]
        );
    } elseif (intval($_GET['page']) < 1 || intval($_GET['page']) > $database->getCountYesterdayPage('products')) {
        unset($_GET['page']);
        header("Location: index.php?filter=Yesterday&page=1");
    } else {
        if (!empty($_GET['page']) && (intval($_GET['page']) < 1 || intval($_GET['page']) > $database->getCountPage('products'))) {
            unset($_GET['page']);
            header("Location: index.php?page=1");
        }
        $view->generate(
            'products_template.php',
            'template_view.php',
            [
                'products' => $database->getDataTodayProduct($_GET['page'] ?? 1, date("Y-m-d", strtotime("-1 days"))),
                'page' => $_GET['page'] ?? 1
            ]
        );
    }
} elseif ($_GET['filter'] === 'All') {

    if (intval($_GET['page']) < 1 || intval($_GET['page']) > $database->getCountPage('products')) {
        unset($_GET['page']);
        header("Location: index.php?page=1");
    }

    $view->generate(
        'products_template.php',
        'template_view.php',
        [
            'products' => $database->getDataProduct($_GET['page'] ?? 1),
            'page' => $_GET['page'] ?? 1
        ]
    );
} else {
    if(!empty ($_GET['page']) && (intval($_GET['page']) < 1 || intval($_GET['page']) > $database->getCountPage('products'))) {
        unset($_GET['page']);
        header("Location: index.php?page=1");
    }

    $view->generate(
        'products_template.php',
        'template_view.php',
        [
            'products' => $database->getDataProduct($_GET['page'] ?? 1),
            'page' => $_GET['page'] ?? 1
        ]
    );
}
