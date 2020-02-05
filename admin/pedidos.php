<?php

/** 
 * Change variables for title and description
 */
$pageTitle = "Pedidos de clientes";
$pageDescriprion = "Visualiza el estado de todos los pedidos";

require '../inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['admin', 'moderador']);
$orders = User::getAllOrders();

?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require '../inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <main>
            <section class="mb-5">
                <div class="row">
                    <h2>Admin pedidos</h2>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-between mb-3">
                        <h4>Pedidos y estado</h4>
                    </div>
                </div>
                <div class="row d-block">

                    <?php if ($orders) : ?>
                        <table class="table table-striped table-hover table-responsive col-12">
                            <thead>
                                <tr>
                                    <th scope="col">Identificador</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orders as $order) :
                                    $totalPrice = 0;
                                    foreach ($currentUser->getOrderLines($order['id']) as $line) :
                                        $product = Product::getById($line['product_id']);
                                        $totalPrice += $line['price'];
                                    endforeach;
                                ?>
                                    <tr class="<?= $product->getDeleted() ? 'opacity' : '' ?>">
                                        <th scope="row"><?= $order['id'] ?></th>
                                        <td><?= $order['purchase_date'] ?></td>
                                        <form action="<?= RUTA_HOME . 'controllers/user.php' ?>" method="POST">
                                            <td>
                                                <select name="status" id="status">
                                                    <option <?= $order['status'] == 'realizado' ? 'selected' : '' ?> value="realizado">realizado</option>
                                                    <option <?= $order['status'] == 'enviado' ? 'selected' : '' ?> value="enviado">enviado</option>
                                                    <option <?= $order['status'] == 'entregado' ? 'selected' : '' ?> value="entregado">entregado</option>
                                                </select>
                                            </td>
                                            <td><?= $totalPrice . ' €' ?></td>
                                            <td>
                                                <input type="hidden" name="action" value="orderStatus">
                                                <input type="hidden" name="orderId" value="<?= $order['id'] ?>">
                                                <input class="btn btn-primary" type="submit" value="Cambiar estado">
                                            </td>
                                        </form>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php else : ?>
                        <p>No hay pedidos realizados</p>
                    <?php endif; ?>

                </div>
            </section>
        </main>
    </div>
    <!-- Aside right -->
    <?php require '../inc/layout/aside-right.php'; ?>
</div>


<?php
require '../inc/layout/footer.php';
?>