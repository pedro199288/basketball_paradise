<?php


class Category
{
    private $id;
    private $name;
    private $category_id;
    private $deleted;
    
    public function __construct()
    { }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getDeleted()
    {
        return $this->deleted;
    }

    private static function db()
    {
        return conn();
    }

    /** get all categories */
    public static function getAll($onlyMain = false, $includeDeleted = false)
    {
        $sqlForMain = $onlyMain ? 'WHERE category_id IS NULL' : '';
        $deletedSql = $includeDeleted ? '' : ($onlyMain ? 'AND deleted = 0' : 'WHERE deleted = 0');
        try {
            $stmt = self::db()->prepare("SELECT * FROM categories $sqlForMain $deletedSql");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Category");
            return $result;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public static function getAllWithoutParentNotMain()
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM categories WHERE category_id = 0");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, "Category");
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
                $stmt = self::db()->prepare("UPDATE categories SET name = :name, category_id = :category_id 
                , deleted = :deleted WHERE id = :id");
                $stmt->execute([
                    ':id' => $this->id,
                    ':name' => $this->name,
                    ':category_id' => $this->category_id,
                    ':deleted' => $this->deleted
                ]);
            } else {
                // save new registry
                $stmt = self::db()->prepare("INSERT INTO categories VALUES(null, :name, :category_id, :deleted)");
                $stmt->execute([
                    ':name' => $this->name,
                    ':category_id' => $this->category_id,
                    ':deleted' => $this->deleted
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

    public static function setTo0ByCategoryId($categoryId) {
        try {
            $stmt = self::db()->prepare("UPDATE categories SET category_id = 0 WHERE category_id = :category_id");
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
            $stmt = self::db()->prepare("UPDATE categories SET deleted = 1 WHERE id = :id");
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() > 0) {
                $response = ['type' => 'success', 'message' => 'Se ha dado de baja la categoría'];
            } else {
                $response = ['type' => 'error', 'message' => 'Ha surgido un error al dar de baja la categoría'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Error: ' . $e->getMessage()];
        }

        return $response;
    }

    public static function getById($id)
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM categories WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            if ($stmt->rowCount() > 0) {
                $category = $stmt->fetch();
                return $category;
            } else {
                $response =  ['type' => 'error', 'message' => 'No se ha encontrado'];
            }
        } catch (Exception $e) {
            $response =  ['type' => 'error', 'message' => 'Ha surgido un error: ' . $e->getMessage()];
        }
        return $response;
    }

    public static function getByCategoryId($categoryId )
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM categories WHERE category_id = :category_id");
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

    public function getSubcategories($includeDeleted = false)
    {
        $deletedSql = $includeDeleted ? '' : 'AND deleted = 0';
        try {
            $stmt = self::db()->prepare("SELECT * FROM categories WHERE category_id = :category_id $deletedSql ");
            $stmt->execute([':category_id' => $this->id]);
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

    public function hasSubcategories()
    {
        try {
            $stmt = self::db()->prepare("SELECT * FROM categories WHERE category_id = :category_id");
            $stmt->execute([':category_id' => $this->id]);
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            return false;
            
        } catch (Exception $e) {
            return false;
        }
    }
}
