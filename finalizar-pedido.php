<?php

/** 
 * Change variables for title and description
 */
$pageTitle = "Finalizar pedido";
$pageDescriprion = null;

require './inc/layout/header.php';

if (!$currentUser) {
    $_SESSION['danger_alerts'][] = 'Debes tener sesión inicada para finalizar el pedido';
    header("Location: " . RUTA_HOME . "index.php");
}

$addresses = $currentUser->getAddresses();
?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <div class="row">              
                <form action="pedido-finalizado.php" method="POST">
                    <p class="h5 border-bottom pb-3 mb-3"> selecciona una de tus direcciones o <a href="<?= RUTA_HOME ?>editar-direccion.php"> añade una nueva</a>.</p>
                    <?php if ($addresses && count($addresses) > 0): ?>
                        <table class="table table-striped table-hover">
                        <?php foreach($addresses as $address): ?>
                            <tr>
                                <td>
                                    <label for="address<?=$address['id']?>">
                                        <input class="mr-2" type="radio" name="address" id="address<?=$address['id']?>" value="<?= $address['id'] ?>">
                                        <?= $address['name'] . ' ' . $address['surname'] ?>
                                    </label>
                                </td>
                                <td>
                                    <label for="address<?=$address['id']?>">
                                        <?= $address['address'] .', '.$address['location'] .', '.$address['province'] .', '. $address['postal_code']?>
                                    </label>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                    <p class="h5 border-bottom pb-3 mb-3">Elige un método de pago</p>
                    <table class="table table-striped table-hover">
                    <tr>
                        <td>
                            <label for="card">
                                <input class="mr-2" type="radio" name="payment_method" id="card" value="card"> Tarjeta de crédito
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="paypal">
                                <input class="mr-2" type="radio" name="payment_method" id="paypal" value="paypal"> Pay Pal
                            </label>
                        </td>
                    </tr>
                    </table>

                    <input class="btn btn-primary float-right mr-2" type="submit" value="Finalizar Pedido">
                </form>
        </div>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>