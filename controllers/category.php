<?php
require('../config/config.php');
require('../config/db.php');
require('../models/User.php');
require('../models/Category.php');
require('../models/Product.php');
require('../utils/sessions.php');

// arrays to store messages
$_SESSION['danger_alerts'] = [];
$_SESSION['success_alerts'] = [];

// current user
$currentUser = $_SESSION['user'];

// check permissions
checkPermisos($currentUser, ['admin', 'moderador']);



$action = $_POST['action'] ??  $_GET['action'] ?? null;
switch ($action) {
    case 'save':
        // category creation
        //check if updating
        $updating = $_POST['updating'];

        $name = $_POST['name'] ?? null;
        $category = !empty($_POST['category']) && is_numeric($_POST['category']) ? $_POST['category'] : null;
        $deleted = !empty($_POST['deleted']) ? 1 : 0;

        if (empty($name)) $_SESSION['danger_alerts']['name'] = 'Rellena el campo nombre';

        if (count($_SESSION['danger_alerts']) === 0) {
            // instanciate category
            $newCategory = new Category();
            if ($updating) {
                $id = (int) $_POST['id'] ?? null;
                $newCategory->setId($id);
            }
            $newCategory->setName($name);
            $newCategory->setCategoryId($category);
            $newCategory->setDeleted($deleted);

            // save category
            $response = $newCategory->save($updating);

            if ($response['type'] == 'success') {
                $_SESSION['success_alerts'][] = $response['message'];
            } else {
                $_SESSION['danger_alerts'][] = $response['message'];
            }
        }

        header("Location: " . RUTA_HOME . 'admin/categorias.php');
        die();
        break;

    case 'delete':
        // get the id
        $id = (int) $_GET['id'] ?? null;
        $response = Product::setToNullByCategoryId($id);
        if ($response['type'] == 'success') {
            $_SESSION['success_alerts'][] = $response['message'];
        } else {
            $_SESSION['danger_alerts'][] = $response['message'];
        }

        // get categories which parent category is the one being deleted and set to 0
        $response = Category::setTo0ByCategoryId($id);
        if ($response['type'] == 'success') {
            $_SESSION['success_alerts'][] = $response['message'];
        } else {
            $_SESSION['danger_alerts'][] = $response['message'];
        }

        $response = Category::delete($id);

        if ($response['type'] == 'success') {
            $_SESSION['success_alerts'][] = $response['message'];
        } else {
            $_SESSION['danger_alerts'][] = $response['message'];
        }
        header("Location: " . RUTA_HOME . 'admin/categorias.php');
        die();
        break;


    default:
        # code...
        break;
}
