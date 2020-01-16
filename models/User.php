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
    {
    }

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
            } else {
                // new registry
                $stmt = self::db()->prepare("INSERT INTO users VALUES(:dni, :name, :surname, :email, :password, :rol, :status)");
            }
            $stmt->execute([
                ':dni' => $this->dni,
                ':name' => $this->name,
                ':surname' => $this->surname,
                ':email' => $this->email,
                ':password' => $this->password,
                ':rol' => $this->rol,
                ':status' => $this->status
            ]);
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
            $stmt = self::db()->prepare("UPDATE users SET status = 'deleted' WHERE dni = :dni");
            $stmt->execute([':dni' => $dni]);

            if ($stmt->rowCount() > 0) {
                $response = ['type' => 'success', 'message' => 'Se ha dado de baja correctamente'];
            } else {
                $response = ['type' => 'error', 'message' => 'Ha surgido un error al dar de baja'];
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
                return false;
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
                return false;
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
        }
        return $response;
    }


    public function getAddresses($deleted = false)
    {
        $sql = $deleted ? 'AND deleted = 1' : 'AND deleted = 0';
        try {
            $stmt = self::db()->prepare("SELECT * FROM addresses WHERE user_dni = :user_dni $sql");
            $stmt->execute([':user_dni' => $this->dni]);
            if ($stmt->rowCount() > 0) {
                $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $addresses;
            } else {
                return null;
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
            return null;
        }
    }

    public function getAddressById($id)
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM addresses WHERE id = :id");
            $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() > 0) {
                $address = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                return $address;
            } else {
                return null;
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
            return null;
        }
    }



    public function saveAddress($updating = false, array $address)
    {
        try {
            if ($updating) {
                $stmt = self::db()->prepare("UPDATE addresses SET name = :name, surname = :surname, address = :address, postal_code = :postal_code, location = :location, province = :province WHERE id = :id");
            } else {
                $query = self::db()->query("SELECT MAX(address_number) as maxNumber FROM addresses WHERE user_dni = '{$this->dni}' ");
                $maxNumber = $query->fetch()['maxNumber'] ?? 0;
                $stmt = self::db()->prepare("INSERT INTO addresses VALUES (null, :user_dni, :address_number, :name, :surname, :address, :postal_code, :location, :province, false)");
            }

            $bindings = [
                ':name' => $address['name'],
                ':surname' => $address['surname'],
                ':address' => $address['address'],
                ':postal_code' => $address['postal_code'],
                ':location' => $address['location'],
                ':province' => $address['province']
            ];

            if (!$updating) {
                $bindings[':user_dni'] = $this->dni;
                $bindings[':address_number'] = ++$maxNumber;
            }

            if ($updating) $bindings[':id'] = $address['id'];

            $stmt->execute($bindings);

            if ($stmt->rowCount() > 0) {
                $response = ['type' => 'success', 'message' => 'Se ha guardado correctamente'];
            } else {
                $response = ['type' => 'error', 'message' => 'Ha surgido un error al guardar'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
        }
        return $response;
    }

    public static function deleteAddress($address)
    {
        try {
            $stmt = self::db()->prepare("UPDATE addresses SET deleted = 1 WHERE id = :id");
            $stmt->execute([':id' => $address['id']]);

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

    public function getOrders()
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM orders WHERE user_dni = :user_dni ORDER BY purchase_date DESC");
            $stmt->execute([':user_dni' => $this->dni]);
            if ($stmt->rowCount() > 0) {
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $orders;
            } else {
                return null;
            }
        } catch (Exception $e) {
            $_SESSION['danger_alerts'][] = 'Ha surgido un error: ' . $e->getMessage();
            return null;
        }
    }

    public static function getOrderById($id)
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM orders WHERE id = :id");
            $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() > 0) {
                $order = $stmt->fetch(PDO::FETCH_ASSOC);
                return $order;
            } else {
                return null;
            }
        } catch (Exception $e) {
            $_SESSION['danger_alerts'][] = 'Ha surgido un error: ' . $e->getMessage();
            return null;
        }
    }

    public function getOrderLines($orderId)
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM line_items WHERE order_id = :order_id");
            $stmt->execute([':order_id' => $orderId]);
            if ($stmt->rowCount() > 0) {
                $lines = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $lines;
            } else {
                return null;
            }
        } catch (Exception $e) {
            $_SESSION['danger_alerts'][] = 'Ha surgido un error: ' . $e->getMessage();
            return null;
        }
    }
}
