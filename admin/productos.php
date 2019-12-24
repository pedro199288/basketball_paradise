<?php

/**
 * Change variables for title and description
 */
$pageTitle = "Ver Productos";
$pageDescriprion = null;

require '../inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['admin', 'moderador']);

// Get all products to show in table
$products = Product::getAll();
?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require '../inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mb-3">
                <h4>Listado Productos</h4>
                <a href="<?= RUTA_HOME ?>admin/editar-producto.php" class="btn btn-primary">Añadir Producto</a>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped table-hover table-responsive col-12">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">nombre</th>
                        <th scope="col">precio</th>
                        <th scope="col">stock</th>
                        <th scope="col">categorias</th>
                        <th scope="col">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <th scope="row"><?= $product->getId() ?></th>
                            <td><?= $product->getName() ?></td>
                            <td><?= $product->getPrice() ?></td>
                            <td><?= $product->getStock() ?></td>
                            <td>
                                <?php foreach ($product->getCategories() as $i => $categoryId) : ?>
                                    <?php $catName = Category::getById($categoryId)->getName(); ?>
                                    <?= $catName . (count($product->getCategories()) == $i+1 ? '' : ',') ?>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <a class="btn btn-secondary" href="editar-producto.php?id=<?= $product->getId() ?>">Editar</a>
                                <a class="btn btn-danger" href="<?= RUTA_HOME ?>admin/editar-producto.php?action=delete&id=<?= $product->getId() ?>">Borrar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Aside right -->
    <?php require '../inc/layout/aside-right.php'; ?>
</div>


<?php
require '../inc/layout/footer.php';
?>