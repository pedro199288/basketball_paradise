<?php
// initialize session in every page
if (!isset($_SESSION)) {
    session_start();
}

function checkPermisos($currentUser, array $roles)
{
    if (
        empty($currentUser) || !in_array($currentUser->getRol(), $roles)
        || (!empty($currentUser) && !in_array($currentUser->getRol(), $roles))
    ) {
        // deny access and redirect to index
        $_SESSION['danger_alerts'][] = "No tienes permisos suficientes";
        header("Location: ".RUTA_HOME."index.php");
        die();
    }
}
