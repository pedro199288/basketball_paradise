<?php


class Product
{
    private $product;
    private $quantity;

    public function __construct()
    {
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    /** get all products */
    public static function getCart()
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
                $stmt = self::db()->prepare("INSERT INTO products VALUES(null, :name, :description, :price, :stock, :categories, :image, NOW())");
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
}
