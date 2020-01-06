<?php

/**
 * Change variables for title and description
 */
$pageTitle = "Ver Categorías";
$pageDescriprion = null;

require '../inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['admin', 'moderador']);

// Get all categories to show in table
$categories = Category::getAll(false, true);
$pag = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? $_GET['pag'] : 1;
$totalCategories = count($categories);
$rowRegistries = 6;
$totalPags = (int) ($totalCategories/$rowRegistries) +1;
$displacement = ($pag * $rowRegistries) - $rowRegistries;
$categories = array_filter($categories, function($p) use ($displacement, $rowRegistries, $pag) {
    return ($p >= $displacement && $p < $rowRegistries * $pag);
}, ARRAY_FILTER_USE_KEY);
?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require '../inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <div class="row">
            <div class="col-12 d-flex justify-content-between mb-3">
                <h4>Listado Categorías</h4>
                <a href="<?= RUTA_HOME ?>admin/editar-categoria.php" class="btn btn-primary">Añadir Categoría</a>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped table-hover table-responsive col-12">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">nombre</th>
                        <th scope="col">categoria principal</th>
                        <th scope="col">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category) : ?>
                        <tr class="<?= $category->getDeleted() ? 'opacity' : '' ?>">
                            <th scope="row"><?= $category->getId() ?></th>
                            <td><?= $category->getName() ?></td>
                            <td><?php echo (is_numeric($category->getCategoryId()) ?
                            ($category->getCategoryId() == 0 ? 
                            'no tiene categoria' 
                            : 
                            Category::getById($category->getCategoryId())->getName()) 
                            : 
                            'ya es principal') ?></td>
                            <td>
                                <a class="btn btn-secondary" href="editar-categoria.php?id=<?= $category->getId() ?>">Editar</a>
                                <a class="btn btn-danger" href="<?= RUTA_HOME ?>admin/editar-categoria.php?action=delete&id=<?= $category->getId() ?>">Borrar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php require '../inc/pagination.php'; ?>
    </div>
    <!-- Aside right -->
    <?php require '../inc/layout/aside-right.php'; ?>
</div>


<?php
require '../inc/layout/footer.php';
?>