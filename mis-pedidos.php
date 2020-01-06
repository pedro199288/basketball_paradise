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
                        <?php 
                            foreach($orders as $order): 
                            $address = $currentUser->getAddressById($order['address']);
                        ?>
                            <article class="border-top border-bottom py-3 mr-2">
                                <h4 class="text-center mb-4"><strong>Número identificador del pedido: </strong> <?= $order['id']?></h4>
                                <p><strong>Direccion: </strong> <?= $address['address'] . ', '. $address['location'] . ', ' . $address['province'] . ', ' . $address['postal_code'] ?></p>
                                <p><strong>Método de pago: </strong> <?= $order['payment_method'] ?></p>
                                <p><strong>Estado: </strong> <?= $order['status'] ?></p>
                                <p><strong>Fecha de compra: </strong> <?= $order['purchase_date'] ?></p>
                                <p><strong>Fecha de envío: </strong> <?= $order['shipping_date']  ?? 'sin enviar' ?></p>
                                <p><strong>Fecha de entrega: </strong> <?= $order['delivery_date'] ?? 'sin entregar'  ?></p>
                                <h5>Líneas del pedido:</h5>
                                <table class="table table-striped table-hover table-responsive w-100">
                                    <thead>
                                        <tr>
                                            <th>Línea</th>
                                            <th>Nombre producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalQtty = 0;
                                        $totalPrice = 0;
                                        foreach ($currentUser->getOrderLines($order['id']) as $line) :
                                            $product = Product::getById($line['product_id']);
                                            $totalQtty += $line['quantity'];
                                            $totalPrice += $line['price'];
                                        ?>
                                            <tr>
                                                <td><?= $line['line_number'] ?></td>
                                                <td><?= $product->getName() ?></td>
                                                <td><?= $line['price'] ?></td>
                                                <td><?= $line['quantity'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="2" class="font-weight-bold">Unidades totales: <?= $totalQtty ?></td>
                                            <td colspan="2" class="font-weight-bold">Precio total: <?= $totalPrice ?>€</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </article>

                        <?php endforeach; ?>
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