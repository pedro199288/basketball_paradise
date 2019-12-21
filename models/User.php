<?php


class User
{
    private $dni;
    private $name;
    private $surname;
    private $email;
    private $password;
    private $rol;
    private $status;

    public function __construct()
    { }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getStatus()
    {
        return $this->status;
    }

    private static function db()
    {
        return conn();
    }

    /** get all users */
    public static function getAll()
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, "User");
            return $result;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function save($updating = false)
    {
        try {
            if ($updating) {
                // update registry
                $stmt = self::db()->prepare("UPDATE users SET dni = :dni, name = :name, surname = :surname, email = :email, password = :password, rol = :rol, status = :status WHERE dni = :dni");
                $stmt->execute([
                    ':dni' => $this->dni,
                    ':name' => $this->name,
                    ':surname' => $this->surname,
                    ':email' => $this->email,
                    ':password' => $this->password,
                    ':rol' => $this->rol,
                    ':status' => $this->status
                ]);
            } else {
                // new registry
                $stmt = self::db()->prepare("INSERT INTO users VALUES(:dni, :name, :surname, :email, :password, :rol, :status)");
                $stmt->execute([
                    ':dni' => $this->dni,
                    ':name' => $this->name,
                    ':surname' => $this->surname,
                    ':email' => $this->email,
                    ':password' => $this->password,
                    ':rol' => $this->rol,
                    ':status' => $this->status
                ]);
            }
            if ($stmt->rowCount() > 0) {
                $response = ['type' => 'success', 'message' => 'Se ha guardado correctamente'];
            } else {
                $response = ['type' => 'error', 'message' => 'Ha surgido un error al guardar'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }
        return $response;
    }

    public static function delete($dni)
    {
        try {
            $stmt = self::db()->prepare("DELETE FROM users WHERE dni = :dni");
            $stmt->execute([':dni' => $dni]);

            if ($stmt->rowCount() > 0) {
                $response = ['type' => 'success', 'message' => 'Se ha borrado correctamente'];
            } else {
                $response = ['type' => 'error', 'message' => 'Ha surgido un error al borrar'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }
        return $response;
    }

    public static function getByDni($dni)
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM users WHERE dni = :dni");
            $stmt->execute([':dni' => $dni]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "User");
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                return $user;
            } else {
                $response =  ['type' => 'error', 'message' => 'No se ha encontrado el cliente'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
        }
        return $response;
    }

    public static function getByEmail($email)
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "User");
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                return $user;
            } else {
                $response =  ['type' => 'error', 'message' => 'No se ha encontrado el cliente'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
        }
        return $response;
    }
}
