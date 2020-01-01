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
        <h2>Carrito</h2>
        <div class="row mx-1">
            <?php if ($currentCart) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-right" title="cantidad">Cantidad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalQtty = 0;
                        $totalPrice = 0;
                        foreach ($currentCart as $productId => $quantity) :
                            $cartProduct = Product::getById($productId);
                            $totalQtty += $quantity;
                            $totalPrice += ($cartProduct->getPrice() * $quantity);
                        ?>
                            <tr>
                                <td><?= $cartProduct->getName() ?></td>
                                <td class="text-right">
                                    <a class="font-weight-bold h4 mr-3 text-decoration-none" href="modificar-carrito.php?id=<?= $cartProduct->getId() . '&reducir' ?>">-</a>
                                    <?= $quantity ?>
                                    <a class="font-weight-bold h4 ml-3 text-decoration-none" href="modificar-carrito.php?id=<?= $cartProduct->getId() ?>">+</a>
                                </td>
                                <td class="text-right">
                                    <a class="btn text-decoration-none" href="modificar-carrito.php?id=<?= $cartProduct->getId() . '&eliminar' ?>">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="font-weight-bold">Unidades totales:</td>
                            <td colspan="2" class="text-right"><?= $totalQtty ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Precio total:</td>
                            <td colspan="2" class="text-right"><?= $totalPrice ?>€</td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-12 d-flex justify-content-between">
                    <a class="btn btn-secondary" href="<?= $_SERVER['HTTP_REFERER'] ?>">Seguir comprando</a>
                    <?php if (!$currentUser) : ?>
                        <p>
                            Para finalizar compra <a href="<?= $_SERVER['PHP_SELF'] . '#user-login' ?>">inicia sesión</a> o <a href="<?= RUTA_HOME . 'registro.php' ?>">regístrate</a>
                        </p>
                    <?php else : ?>
                        <a class="btn btn-primary" href="finalizar-pedido.php">Finalizar pedido</a>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <p class="h6 mx-auto mt-4">El carrito está vacío</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>