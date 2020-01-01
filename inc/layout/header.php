<?php
$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/tienda-online-daw/';
require $ROOT_PATH . 'config/config.php';
require $ROOT_PATH . 'config/db.php';
require $ROOT_PATH . 'utils/utils.php';
require $ROOT_PATH . 'models/User.php';
require $ROOT_PATH . 'models/Category.php';
require $ROOT_PATH . 'models/Product.php';
require $ROOT_PATH . 'utils/sessions.php';

// close session
if (isset($_GET['logout'])) {
    $_SESSION['user'] = null;
    $_SESSION['success_alerts'][] = 'Sesión cerrada correctamente!';
    header("Location: " . RUTA_HOME . "index.php");
    die();
}

// current user to use in the whole application
$currentUser = $_SESSION['user'] ?? null;
if(isset($_COOKIE['cart'])) {
    $currentCart = json_decode($_COOKIE['cart'], true);
} else {
    $currentCart = null;
}

// TODO: get the links from a function
$links = [
    [
        'text' => 'Inicio',
        'link' => RUTA_HOME . 'index.php'
    ],
    [
        'text' => 'Ofertas',
        'link' => RUTA_HOME . 'ofertas.php'
    ],
    [
        'text' => 'Quienes Somos',
        'link' => RUTA_HOME . 'quienes-somos.php'
    ],
    [
        'text' => 'Contacto',
        'link' => RUTA_HOME . 'contacto.php'
    ]
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $pageTitle ?? "Basketball's Paradise" ?></title>
    <meta name="description" content="<?= $pageDescription ?? "La mejor tienda online de baloncesto" ?>">
    <!-- link for bootstrap -->
    <link rel="stylesheet" href="<?= RUTA_HOME ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= RUTA_HOME ?>assets/css/main.css">
</head>

<body class="d-flex">
    <div class="col-12 main-container px-0">
        <header class="col-12 mb-3">
            <div class="row bg-page">
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <a class="my-4 d-block logo-header" href="<?= RUTA_HOME ?>index.php">
                                <img class="d-block" src="<?= RUTA_HOME ?>assets/img/logos/default-monochrome-white.svg" alt="Logo tienda">
                            </a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <nav class="nav col-12 justify-content-center">
                            <?php foreach ($links as $link) : ?>
                                <a class="nav-link border text-dark font-weight-bold btn-light mx-1" href="<?= $link['link'] ?>"><?= $link['text'] ?></a>
                            <?php endforeach; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <div class="container-md">
            <?php showAlerts(); ?>