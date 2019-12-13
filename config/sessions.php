<?php
// initialize session in every page
if (!isset($_SESSION)) {
    session_start();
}

function checkPermisos($currentUser, array $roles) {
    if(empty($currentUser) || !in_array($currentUser->getRol(), $roles) ) {
        $_SESSION['danger_alerts'][] = "No tienes permisos suficientes";
        header("Location: index.php");
        die();
    }

    // check permissions if ther is currentUser
    if(!in_array($currentUser->getRol(), $roles)) {
        
    }
}