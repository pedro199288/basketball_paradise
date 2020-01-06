<?php

/**
 * Change variables for title and description
 */
$pageTitle = "Ver Categorías";
$pageDescriprion = null;

require '../inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['admin', 'moderador']);

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $categoryId = $_GET['id'];
    $pageTitle2 = 'Editar Categoría con id ' . $categoryId;
    // fetch categorytData
    $currentCategory = Category::getById($categoryId);
} else {
    $pageTitle2 = 'Crear Categoría';
    $currentCategory = null;
}

// Get the main categories to show them in select's options
$mainCategories = Category::getAll(true);


if (isset($_GET['action']) && $_GET['action'] == 'delete') : ?>
    <div class="modal" style="display: block" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Borrar categoría?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Si borras la categoría, es posible que algunos productos o categorías se queden sin su categoría padre y tendrás que reasignarlos a una categoría. ¿Quieres continuar?</p>
                </div>
                <div class="modal-footer">
                    <a href="<?= RUTA_HOME ?>controllers/category.php?action=delete&id=<?= $_GET['id'] ?>" class="btn btn-danger">Borrar</a>
                    <a href="<?= RUTA_HOME ?>admin/editar-categoria.php?id=<?= $_GET['id'] ?>" class=" btn btn-secondary" data-dismiss="modal">Cancelar</a>
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
            <h4><?= $pageTitle2 ?></h4>
        </div>
        <form action="<?= RUTA_HOME ?>controllers/category.php" method="POST">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $currentCategory ? $currentCategory->getName() : '' ?>">
            </div>
            <div class="form-group">
                <label for="category">Categoría a la que pertenece</label>
                <small class="muted-text">Dejar valor por defecto si es una categoría principal</small>
                <select class="form-control" name="category" id="category">
                    <option value=null>Es Categoría Principal</option>
                    <?php foreach ($mainCategories as $mainCategory) : ?>
                        <option <?= ($mainCategory->getId() === ($currentCategory ? $currentCategory->getCategoryId() : 'fad')) ? 'selected' : '' ?> value="<?= $mainCategory->getId() ?>"><?= $mainCategory->getName() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" name="id" value=<?= $currentCategory ?  $currentCategory->getId() : null ?>>
            <input type="hidden" name="updating" value=<?= $currentCategory ? true : false ?>>
            <button name="action" value="save" type="submit" class="btn btn-primary font-weight-bold">Guardar</button>
        </form>
    </div>
    <!-- Aside right -->
    <?php require '../inc/layout/aside-right.php'; ?>
</div>


<?php
require '../inc/layout/footer.php';
?>