<?php

/**
 * Change variables for title and description
 */
$pageTitle = "Ver Usuarios";
$pageDescriprion = null;

require '../inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['admin']);

// Get all employee to show in table
$users = User::getAll();
$pag = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? $_GET['pag'] : 1;
$totalUsers = count($users);
$rowRegistries = 6;
$totalPags = ceil($totalUsers / $rowRegistries);
$displacement = ($pag * $rowRegistries) - $rowRegistries;
$users = array_filter($users, function ($user) use ($displacement, $rowRegistries, $pag) {
    return ($user >= $displacement && $user < $rowRegistries * $pag);
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
                <h4>Listado Usuarios</h4>
                <a href="<?= RUTA_HOME ?>admin/editar-usuario.php" class="btn btn-primary">Añadir Usuario</a>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped table-hover table-responsive col-12">
                <thead>
                    <tr>
                        <th scope="col">DNI</th>
                        <th scope="col">email</th>
                        <th scope="col">rol</th>
                        <th scope="col">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr class="<?= $user->getStatus() === 'deleted' ? 'opacity' : '' ?>">
                            <th scope="row"><?= $user->getDni() ?></th>
                            <td><?= $user->getEmail() ?></td>
                            <td><?= $user->getRol() ?></td>
                            <td>
                                <a class="btn btn-secondary" href="editar-usuario.php?dni=<?= $user->getDni() ?>">Editar</a>
                                <a class="btn btn-danger" href="<?= RUTA_HOME ?>admin/editar-usuario.php?action=delete&dni=<?= $user->getDni() ?>">Borrar</a>
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