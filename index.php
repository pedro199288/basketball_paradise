<?php

/** 
 * Change variables for title and description
 */
$pageTitle = "Basketball Paradise";
$pageDescriprion = null;

require './inc/layout/header.php';

// Get all products to show in table
$products = Product::getAll();
?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <h2>Productos más recientes</h2>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 justify-content-around">
            <?php foreach ($products as $product) : ?>
                <div class="card product-card mx-1 my-1">
                    <img src="<?= RUTA_HOME . 'assets/img/products/' . (!empty($product->getImage()) ? $product->getImage() : 'default.svg') ?>" class="card-img-top" alt="<?= $product->getName() ?>">
                    <div class="card-body d-flex text-center flex-wrap">
                        <div class="w-100 align-self-start">
                            <h5 class="card-title"><?= $product->getName() ?></h5>
                            <p class="card-text text-center font-weight-bold card-subtitle text-secondary my-1 h4"><?= $product->getPrice() . ' €' ?></p>
                        </div>
                        <a href="#" class="btn btn-primary btn-block mt-2 align-self-end">Comprar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>