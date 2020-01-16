<?php

/**
 * Change variables for title and description
 */
$pageTitle = "Ver Productos";
$pageDescriprion = null;

require '../inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['admin', 'moderador']);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];
    $pageTitle2 = 'Editar Producto con id ' . $productId;
    // fetch producttData
    $product = Product::getById($productId);
} else {
    $pageTitle2 = 'Crear Producto';
    $product = null;
}

// Get all categories to show in the select as optgroup
$mainCategories = Category::getAll(true);

if (isset($_GET['action']) && $_GET['action'] == 'delete') : ?>
    <div class="modal" style="display: block" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Borrar producto?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Después de borrar este producto, dejará de estar disponible en la tienda, ¿Quieres continuar?</p>
                </div>
                <div class="modal-footer">
                    <a href="<?= RUTA_HOME ?>controllers/product.php?action=delete&id=<?= $_GET['id'] ?>" class="btn btn-danger">Borrar</a>
                    <a href="<?= RUTA_HOME ?>admin/editar-producto.php?id=<?= $_GET['id'] ?>" class=" btn btn-secondary" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require '../inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mb-3">
                <h4><?= $pageTitle2 ?></h4>
                <a href="<?= RUTA_HOME ?>admin/editar-producto.php" class="btn btn-primary">Añadir Producto</a>
            </div>
        </div>
        <form action="<?= RUTA_HOME ?>controllers/product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $product ? $product->getName() : '' ?>">
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description"><?= $product ? $product->getDescription() : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $product ? $product->getPrice() : '' ?>">
            </div>
            <div class="form-group">
                <label for="stock">Stock disponible</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?= $product ? $product->getStock() : '' ?>">
            </div>
            <div class="form-group">
                <label for="categories">Categorías</label>
                <small class="text-muted">puede pertenecer a varias (selecciona varias con ctrl + clic)</small>
                <select class="form-control" style="min-height: 250px" multiple name="categories[]" id="categories">
                    <option value=null>Sin Categoría</option>
                    <?php foreach ($mainCategories as $mainCategory) : ?>
                        <optgroup label="<?= $mainCategory->getName() ?>">
                            <?php if ($mainCategory->hasSubcategories()) : ?>
                                <?php foreach ($mainCategory->getSubcategories() as $secondaryCategory) : ?>
                                    <option <?= in_array($secondaryCategory->getId(), ($product ? $product->getCategories() : [])) ? 'selected' : '' ?> value="<?= $secondaryCategory->getId() ?>">
                                        <?= $secondaryCategory->getName() ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </optgroup>
                    <?php endforeach; ?>
                    <optgroup label="Otras Categorías">
                        <?php
                        $categoriesWithoutParentNotMain = Category::getAllWithoutParentNotMain();
                        foreach ($categoriesWithoutParentNotMain as $category) :
                        ?>
                            <option <?= in_array($category->getId(), ($product ? $product->getCategories() : [])) ? 'selected' : '' ?> value="<?= $category->getId() ?>">
                                <?= $category->getName() ?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Imagen</label>
                <input type="file" class="form-control-file" name="image" id="image">
                <img class="mt-2 rounded px-0 col-sm-4" src="<?= RUTA_HOME . 'assets/img/products/' . ($product && !empty($product->getImage()) ? $product->getImage() : 'default.svg') ?>" alt="<?= $product ? $product->getName() : 'sin imagen' ?>">
            </div>
            <div class="form-group">
                <label for="deleted">Is Deleted?</label>
                <input type="checkbox" name="deleted" id="deleted" <?= ($product && $product->getDeleted()) ? 'checked' : '' ?>>
            </div>
            <input type="hidden" name="id" value=<?= $product ?  $product->getId() : null ?>>
            <input type="hidden" name="updating" value=<?= $product ? true : false ?>>
            <button name="action" value="save" type="submit" class="btn btn-primary font-weight-bold">Guardar</button>
        </form>
    </div>
    <!-- Aside right -->
    <?php require '../inc/layout/aside-right.php'; ?>
</div>


<?php
require '../inc/layout/footer.php';
?>