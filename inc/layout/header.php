<?php
require 'config/config.php';
require 'config/utils.php';
require 'models/User.php';
require 'config/sessions.php';

// close session
if(isset($_GET['logout'])){
    $_SESSION['user'] = null;
}

// current user to use in the whole application
$currentUser = $_SESSION['user'] ?? null;

// TODO: get the links from a function
$links = [
    [
        'text' => 'Inicio',
        'link' => 'index.php'
    ],
    [
        'text' => 'Quienes Somos',
        'link' => 'quienes-somos.php'
    ],
    [
        'text' => 'Contacto',
        'link' => 'products?category=tank_top'
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body class="d-flex">
    <div class="container-lg main-container px-0">
        <header class="col-12 mb-3">
            <div class="row bg-page">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <a class="my-4  d-block logo-header" href="index.php">
                                <img class="d-block" src="assets/img/logos/default-monochrome-white.svg" alt="Logo tienda">
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
        <?php showAlerts(); ?>