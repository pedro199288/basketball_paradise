<?php
require('../config/config.php');
require('../config/db.php');
require('../models/User.php');
require('../utils/sessions.php');

// arrays to store messages
$_SESSION['danger_alerts'] = [];
$_SESSION['success_alerts'] = [];

// current user
$currentUser = $_SESSION['user'];

$action = $_POST['action'] ?? $_GET['action'] ?? null;
switch ($action) {
    case 'save':
        // user registration

        //check if updating
        $updating = isset($_POST['updating']) ? $_POST['updating'] : false;

        // validate fields: dni, email and password
        if (!empty($_POST['dni'])) {
            $dni = $_POST['dni'];
            preg_match('/[0-9]{8}[a-zA-Z]/', $dni, $matches);
            if (!$matches) {
                $_SESSION['danger_alerts']['dni'] = 'El DNI debe ser formado por 8 digitos y una letra';
            } else {
                // check if dni exists
                $existeDni = User::getByDni($dni);

                if ($existeDni instanceof User && $currentUser && $existeDni->getDni() == $currentUser->getDni())
                    $updatingCurrentUser = true;

                if ($currentUser->getRol() != 'admin' && (($existeDni instanceof User && !$updating) || ($updating && $existeDni instanceof User && $existeDni->getDni() != $currentUser->getDni()))) {
                    $_SESSION['danger_alerts']['dni'] = 'El DNI ya existe';
                }
            }
        } else {
            $_SESSION['danger_alerts']['dni'] = 'Rellena el campo dni';
            $dni = null;
        }

        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
            // check if email exists
            $existeEmail = User::getByEmail($email);
            if ($existeEmail instanceof User && $currentUser && $existeEmail->getEmail() == $currentUser->getEmail()) $updatingCurrentUser = true;

            if ($currentUser->getRol() != 'admin' && (($existeEmail instanceof User  && !$updating) || ($updating && $existeEmail instanceof User && $existeEmail->getEmail() != $currentUser->getEmail()))) {
                $_SESSION['danger_alerts']['email'] = 'El email ya existe';
            }
        } else {
            $_SESSION['danger_alerts']['email'] = 'Rellena el campo email';
            $email = null;
        }

        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
            // hash the password
            $password = password_hash($password, PASSWORD_BCRYPT);
        } else {
            if (!$updating) {
                $_SESSION['danger_alerts']['password'] = 'Rellena el campo password';
                $password = null;
            }
        }

        $dni = $_POST['dni'] ?? null;
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $surname = $_POST['surname'] ?? null;
        $rol = $_POST['rol'] ?? 'cliente';
        $status = $_POST['status'] ?? 'active';

        // store filled fields
        $_SESSION['filled'] = [
            'dni' => $dni,
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'rol' => $rol,
            'status' => $status,

        ];

        if (count($_SESSION['danger_alerts']) === 0) {
            // instanciate user
            $newUser = new User();
            if ($updating) {
                $newUser = $existeDni;
            }
            
            $newUser->setDni($dni);
            $newUser->setName($name);
            $newUser->setSurname($surname);
            $newUser->setEmail($email);
            if (!empty($password)) {
                $newUser->setPassword($password);
            }
            $newUser->setRol($rol);
            $newUser->setStatus($status);

            // save user
            $response = $newUser->save($updating);

            if ($response['type'] == 'success') {
                $_SESSION['success_alerts'][] = $response['message'];
                if ($updatingCurrentUser) {
                    $_SESSION['user'] = $newUser;
                }
                $_SESSION['filled'] = null;
            } else {
                $_SESSION['danger_alerts'][] = $response['message'];
            }
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
        break;



    case 'login':
        //user login
        if (!empty($_POST['loginEmail'])) {
            $email = $_POST['loginEmail'];
        } else {
            $_SESSION['danger_alerts']['loginEmail'] = 'Rellena el campo email';
            $email = null;
        }

        if (!empty($_POST['loginPassword'])) {
            $password = $_POST['loginPassword'];
        } else {
            $_SESSION['danger_alerts']['loginPassword'] = 'Rellena el campo password';
            $password = null;
        }
        // store filled fields
        $_SESSION['filled'] = ['loginEmail' => $email];

        $loginUser = User::getByEmail($email);
        if ($loginUser instanceof User && $loginUser->getStatus() != 'borrado') {
            // user exists and is not deleted,check password
            $hashed_password = $loginUser->getPassword();
            if (password_verify($password, $hashed_password)) {
                // correct password, store user in SESSION
                $_SESSION['success_alerts'][] = 'Login correcto, estás dentro!';
                $_SESSION['filled'] = null;
                $_SESSION['user'] = $loginUser;
            } else {
                $_SESSION['danger_alerts']['loginPassword'] = 'Password incorrecto';
            }
        } else {
            $_SESSION['danger_alerts']['loginEmail'] = 'No existe ningún usuario con este email o se ha dado de baja';
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
        break;


    case 'delete':
        //user login
        $dni = $_GET['dni'] ?? null;

        if ($dni) {
            $response = User::delete($dni);
            if ($response['type'] == 'success') {
                $_SESSION['success_alerts'][] =  $response['message'];
                $_SESSION['user'] = null;
            } else {
                $_SESSION['danger_alerts'][] = $response['message'];
            }
        } else {
            $_SESSION['danger_alerts'][] = $response['message'];
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
        break;


    case 'save_address':
        // address saving
        //check if updating
        $updating = $_POST['updating'] ? true : false;

        // validate fields
        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
        } else {
            $_SESSION['danger_alerts']['address'] = 'Rellena el campo direccion';
            $address = null;
        }

        if (!empty($_POST['postal_code'])) {
            $postal_code = $_POST['postal_code'];
        } else {
            $_SESSION['danger_alerts']['postal_code'] = 'Rellena el campo de código postal';
            $postal_code = null;
        }

        if (!empty($_POST['location'])) {
            $location = $_POST['location'];
        } else {
            $_SESSION['danger_alerts']['location'] = 'Rellena el campo de localidad';
            $location = null;
        }

        if (!empty($_POST['province'])) {
            $province = $_POST['province'];
        } else {
            $_SESSION['danger_alerts']['province'] = 'Rellena el campo de provincia';
            $province = null;
        }


        $name = $_POST['name'] ?? null;
        $surname = $_POST['surname'] ?? null;

        // store filled fields
        $_SESSION['filled'] = [
            'name' => $name,
            'surname' => $surname,
            'address' => $address,
            'postal_code' => $postal_code,
            'location' => $location,
            'province' => $province,
        ];

        if (count($_SESSION['danger_alerts']) === 0) {
            // create array with the full address
            $addressArray = [];

            if ($updating) {
                $addressArray['id'] = $_POST['id'];
            }
            $addressArray['name'] = $name;
            $addressArray['surname'] = $surname;
            $addressArray['address'] = $address;
            $addressArray['postal_code'] = $postal_code;
            $addressArray['location'] = $location;
            $addressArray['province'] = $province;

            //  save address
            $response = $currentUser->saveAddress($updating, $addressArray);

            if ($response['type'] == 'success') {
                $_SESSION['success_alerts'][] = $response['message'];
                $_SESSION['filled'] = null;
            } else {
                $_SESSION['danger_alerts'][] = $response['message'];
            }
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
        break;

    case 'delete_address':
        $addressArray['id'] = $_GET['id'];

        echo $addressArray;

        $response = User::deleteAddress($addressArray);

        if ($response['type'] == 'success') {
            $_SESSION['success_alerts'][] = $response['message'];
            $_SESSION['filled'] = null;
        } else {
            $_SESSION['danger_alerts'][] = $response['message'];
        }

        header("Location: " . RUTA_HOME . 'editar-usuario.php');
        die();
        break;


    default:
        echo 'nada';
        break;
}
