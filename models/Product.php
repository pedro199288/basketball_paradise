<?php


class Product
{
    private $id;
    private $name;
    private $decription;
    private $price;
    private $stock;
    private $categories;
    private $image;

    public function __construct()
    {
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function setCategories($categories)
    {
        $this->categories = json_encode($categories);
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getCategories()
    {
        return json_decode($this->categories);
    }

    public function getImage()
    {
        return $this->image;
    }

    private static function db()
    {
        return conn();
    }

    /** get all products */
    public static function getAll()
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM products ORDER BY modified DESC");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Product");
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
                $stmt = self::db()->prepare("UPDATE products SET name = :name, description = :description, price = :price, stock = :stock, categories = :categories, image = :image, modified = NOW() WHERE id = :id");
                $stmt->execute([
                    ':id' => $this->id,
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':price' => $this->price,
                    ':stock' => $this->stock,
                    ':categories' => $this->categories,
                    ':image' => $this->image,
                ]);
            } else {
                // save new registry
                $stmt = self::db()->prepare("INSERT INTO products VALUES(null, :name, :description, :price, :stock, :categories, :image)");
                $stmt->execute([
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':price' => $this->price,
                    ':stock' => $this->stock,
                    ':categories' => $this->categories,
                    ':image' => $this->image,
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

    public static function setToNullByCategoryId($categoryId)
    {
        try {
            // TODO: VER COMO ACCEDER A LOS DATOS DEL JSON PARA COMPROBAR $categoryId
            $stmt = self::db()->prepare("UPDATE products SET categories = NULL WHERE category_id = :category_id");
            $stmt->execute([':category_id' => $categoryId]);

            if ($stmt->rowCount() > 0) {
                $response = ['type' => 'success', 'message' => 'Se han actualizado categorias hijas'];
            } else {
                $response = ['type' => 'error', 'message' => 'No se han actualizado categorías hijas'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        return $response;
    }

    public static function delete($id)
    {
        // delete registry
        try {
            $stmt = self::db()->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);

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

    public static function getById($id)
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            if ($stmt->rowCount() > 0) {
                $product = $stmt->fetch();
                return $product;
            } else {
                $response =  ['type' => 'error', 'message' => 'No se ha encontrado'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
        }
        return $response;
    }

    public static function getByCategoryId($categoryId)
    {
        try {
            // TODO: ver como ver $categoryId en el JSON de categories
            $stmt = self::db()->prepare("SELECT * FROM products WHERE category_id = :category_id");
            $stmt->execute([':category_id' => $categoryId]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            if ($stmt->rowCount() > 0) {
                $categories = $stmt->fetchAll();
                return $categories;
            } else {
                $response = ['type' => 'error', 'message' => 'No se han encontrado datos'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        return $response;
    }
}
