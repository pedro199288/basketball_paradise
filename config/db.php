<?php
/** connection to database */
function conn() {
    try {
        $db = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASS); 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES utf8");

        return $db;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}