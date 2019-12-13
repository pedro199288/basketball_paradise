<?php
/** connection to database */
function conn() {
    try {
        $db = new PDO('mysql:host=localhost;dbname='.DB_NAME, 'root', ''); // TODO: cambiar usuario y contraseña a "jefe" y crear este usuario para la bd con sql
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES utf8");

        return $db;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}