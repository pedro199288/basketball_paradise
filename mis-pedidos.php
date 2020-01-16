<?php


/** 
 * Change variables for title and description
 */
$pageTitle = "Mis pedidos";
$pageDescriprion = "Visualiza el estado de tus pedidos";

require './inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['cliente', 'admin', 'moderador']);
$orders = $currentUser->getOrders();

?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <main>
            <section class="mb-5">
                <div class="row">
                    <h2>Mis pedidos</h2>
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

                                    $address = $currentUser->getAddressById($order['address']);
                                    $totalPrice = 0;
                                    foreach ($currentUser->getOrderLines($order['id']) as $line) :
                                        $product = Product::getById($line['product_id']);
                                        $totalPrice += $line['price'];
                                    endforeach;
                                ?>
                                    <tr class="<?= $product->getDeleted() ? 'opacity' : '' ?>">
                                        <th scope="row"><?= $order['id'] ?></th>
                                        <td><?= $order['purchase_date'] ?></td>
                                        <td><?= $order['status'] ?></td>
                                        <td><?= $totalPrice . ' €' ?></td>
                                        <td>
                                            <a class="btn btn-secondary" href="ver-pedido.php?id=<?= $order['id']  ?>">Ver</a>
                                        </td>
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
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>