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

$action = $_POST['action'] ?? $_GET['action'] ?? null;
switch ($action) {
    case 'save':
        // product creation
        //check if updating
        $updating = $_POST['updating'];

        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $price = $_POST['price'] ?? null;
        $stock = $_POST['stock'] ?? null;
        $categories = !empty($_POST['categories']) ? $_POST['categories'] : null;
        $deleted = !empty($_POST['deleted']) ? $_POST['deleted'] : 0;

        if (empty($name)) $_SESSION['danger_alerts']['name'] = 'Rellena el campo nombre';
        if (empty($price)) $_SESSION['danger_alerts']['price'] = 'Rellena el campo precio';

        if (count($_SESSION['danger_alerts']) === 0) {
            // instanciate product
            $newProduct = new Product();
            if ($updating) {
                $id = (int) $_POST['id'] ?? null;
                $newProduct = Product::getById($id);
            }

            if (!empty($_FILES['image']['name'])) {
                if ($_FILES['image']['size'] > 2000000) {
                    $_SESSION['danger_alerts'][] = 'Error al subir la imagen (excede 2MB)';
                } else {
                    // if image, upload it first, then store data in database
                    $uploadFolder = '../assets/img/products/';
                    $uploadedFile = $uploadFolder . basename($_FILES['image']['name']);
                    $fileType = getimagesize($_FILES['image']['tmp_name'])['mime'];
                    $fileMime = substr($fileType, strpos($fileType, '/') + 1);
                    $allowedMimes = ['jpe', 'jpeg', 'jpg', 'png', 'webp'];
                    if (in_array($fileMime, $allowedMimes) && move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
                        $image = $_FILES['image']['name'] ?? null;

                        $newProduct->setImage($image);
                        $_SESSION['success_alerts'][] = 'Imagen subida correctamente';
                    } else {
                        $_SESSION['danger_alerts'][] = 'Error al subir la imagen';
                    }
                }
            }

            $newProduct->setName($name);
            $newProduct->setDescription($description);
            $newProduct->setPrice($price);
            $newProduct->setStock($stock);
            $newProduct->setCategories($categories);
            $newProduct->setDeleted($deleted);

            // save Product
            $response = $newProduct->save($updating);

            if ($response['type'] == 'success') {
                $_SESSION['success_alerts'][] = $response['message'];
            } else {
                $_SESSION['danger_alerts'][] = $response['message'];
            }
        }

        header("Location: " . RUTA_HOME . 'admin/productos.php');
        die();
        break;



    case 'delete':
        // get the id
        $id = (int) $_GET['id'] ?? null;
        $response = Product::delete($id);

        if ($response['type'] == 'success') {
            $_SESSION['success_alerts'][] = $response['message'];
        } else {
            $_SESSION['danger_alerts'][] = $response['message'];
        }
        header("Location: " . RUTA_HOME . 'admin/productos.php');
        die();
        break;


    default:
        # code...
        break;
}
