<?php
require('../config/config.php');
require('../config/db.php');
require('../models/User.php');
require('../config/sessions.php');

// arrays to store messages
$_SESSION['danger_alerts'] = [];
$_SESSION['success_alerts'] = [];

// current user
$currentUser = $_SESSION['user'];

$action = $_POST['action'] ?? null;
switch ($action) {
    case 'save':
        // user registration

        //check if updating
        $updating = $_POST['updating'] ? true : false;
        
        // validate fields: dni, email and password
        if (!empty($_POST['dni'])) {
            $dni = $_POST['dni'];
            preg_match('/[0-9]{8}[a-zA-Z]/', $dni, $matches);
            if (!$matches) {
                $_SESSION['danger_alerts']['dni'] = 'El DNI debe ser formado por 8 digitos y una letra';
            } else {
                // check if dni exists
                $existeDni = User::getByDni($dni);

                if ($existeDni instanceof User && $existeDni->getDni() == $currentUser->getDni()) $updatingCurrentUser = true;

                if (($existeDni instanceof User && !$updating) || ($updating && $existeDni instanceof User && $existeDni->getDni() != $currentUser->getDni())) {
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
            if ($existeEmail instanceof User && $existeEmail->getEmail() == $currentUser->getEmail()) $updatingCurrentUser = true;

            if (($existeEmail instanceof User  && !$updating) || ($updating && $existeEmail instanceof User && $existeEmail->getEmail() != $currentUser->getEmail())) {
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


        $name = $_POST['name'] ?? null;
        $surname = $_POST['surname'] ?? null;
        $rol = $_POST['rol'] ?? 'cliente';
        $status = $_POST['status'] ?? 'activo';

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
            if($updating){
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
        if ($loginUser instanceof User) {
            // user exists,check password
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
            $_SESSION['danger_alerts']['loginEmail'] = 'No existe ningún usuario con este email';
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
        break;


    default:
        # code...
        break;
}
