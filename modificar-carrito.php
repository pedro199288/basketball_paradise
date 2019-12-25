<?php
require('./inc/layout/header.php');
if(isset($_GET["id"])) {
    $productId = $_GET["id"];
    if(isset($currentCart)) {
        if(isset($currentCart[$productId])) {
            if(isset($_GET['reducir'])) {
                if($currentCart[$productId] == 1) {
                    unset($currentCart[$productId]);
                } else {
                    $currentCart[$productId]--;
                }
            } else if( isset($_GET['eliminar']) ) {
                unset($currentCart[$productId]);            
            } else {
                $currentCart[$productId]++;
            }
        } else {
            $currentCart[$productId] = 1;
        }
    } else {
        $currentCart[$productId] = 1;
    }
    $currentCart = json_encode($currentCart);
    setcookie("cart", $currentCart, time()+3600 );
    $_SESSION['success_alerts'][] = 'Producto añadido al carrito';
}
header("Location: ".$_SERVER['HTTP_REFERER'] ?? RUTA_HOME);