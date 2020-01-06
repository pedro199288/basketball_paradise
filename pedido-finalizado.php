<?php

/** 
 * Change variables for title and description
 */
$pageTitle = "Pedido finalizado";
$pageDescriprion = "Gracias por tu compra";

require './inc/layout/header.php';

// check if currentCart and if the form inputs are filled
if($currentCart) {
    if( !isset($_POST['address']) || empty($_POST['address']) || !isset($_POST['payment_method']) || empty($_POST['payment_method']) ) {
        $_SESSION['danger_alerts'][] = 'Elige una dirección de envío y un método de pago';
        header('Location: '. RUTA_HOME .'finalizar-pedido.php');
        die();
    } else {
        $address = $_POST['address'];
        $payment_method = $_POST['payment_method'];
        $status = 'realizado';
        $purchase_date = date('Y-m-d h:i:s');
        $shipping_date = null;
        $delivery_date = null;

        // store in database
        $db = conn();
        
        $stmt = $db->prepare(" INSERT INTO orders VALUES (null, :user_dni, :address, :payment_method, :status, :purchase_date, :shipping_date, :delivery_date) ");
        
        $stmt->execute([
            ':user_dni' => $currentUser->getDni(),
            ':address' => $address,
            ':payment_method' => $payment_method,
            ':status' => $status,
            ':purchase_date' => $purchase_date,
            ':shipping_date' => $shipping_date,
            ':delivery_date' => $delivery_date
            ]);

        if ($stmt->rowCount() > 0) {
            //store the lastinsertid to use it on the line_items insertions
            $order_id = $db->lastInsertId();

            // order_id	line_number	product_id	price	quantity
            $counter = 1;
            foreach ($currentCart as $productId => $qty) {
                $stmt2 = $db->prepare(" INSERT INTO line_items VALUES (null, :order_id, :line_number, :product_id, :price, :quantity ) ");

                $stmt2->execute([
                    ':order_id' => $order_id,
                    ':line_number' => $counter,
                    ':product_id' => $productId,
                    ':price' => Product::getById($productId)->getPrice(),
                    ':quantity' => $qty
                ]);

                $counter++;
            }

            if ($stmt2->rowCount() > 0) {
                $_SESSION['success_alerts'][] = 'Se ha guardado correctamente';
                // delete the cookie and the cart variable
                $currentCart = null;
                setcookie("cart", 0, time() - 3600);

                header('Location: pedido-finalizado.php');
                die();
            } else {
                $_SESSION['danger_alerts'][] = 'Ha surgido un error al guardar';
            }
        } else {
            $_SESSION['danger_alerts'][] = 'Ha surgido un error al guardar';
        }
        





    }
}
?>


<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <div class="row">              
            <p class="h5">Tu pedido se ha completado correctamete, puedes echar un vistazo al estado de este y otros pedidos en la sección "<a href="<?= RUTA_HOME ?>mis-pedidos.php">Mis Pedidos</a>" de tu perfil.</p>
        </div>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>