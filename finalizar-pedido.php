<?php

/** 
 * Change variables for title and description
 */
$pageTitle = "Gracias por tu compra";
$pageDescriprion = null;

require './inc/layout/header.php';
require './models/Order.php';


//TODO: En esta página dar a elegir la dirección de envío o la posibilidad de añadir una nueva / también métodos de pago (falso)

if(isset($_GET['finalizar'])){
    // save the cart in a new order if 
    $currentOrder = new Order();
    foreach ($currentCart as $line) {
        $currentOrder->addLine($line);
    }
    $currentOrder->setUserDni($currentUser->getDni());
    $currentOrder->setStatus('realizado');
    $currentOrder->save();
    
    die();
    // delete the cookie and the cart variable
    $currentCart = null;
    setcookie("cart", 0, time() - 3600);

    // TODO: Redirect to thank you page or to mis-pedidos
}

?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <h2>Gracias por tu compra!</h2>
        <div class="row">
            <p class="h5">Tu pedido se ha guardado y será envíado en el menor tiempo posible</p>
        </div>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>