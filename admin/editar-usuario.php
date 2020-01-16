<?php

/**
 * Change variables for title and description
 */
$pageTitle = "Ver Usuarios";
$pageDescriprion = null;

require '../inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['admin']);

if (isset($_GET['dni'])) {
    $userDni = $_GET['dni'];
    $pageTitle2 = 'Editar usuario con dni: ' . $userDni;
    // fetch user Data
    $updatingUser = User::getByDni($userDni);
} else {
    $pageTitle2 = 'Crear Usuario';
    $updatingUser = null;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') : ?>
    <!-- <div class="modal" style="display: block" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Borrar usuario?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Después de borrar este usuario, no podrá acceder a la tienda, ¿Quieres continuar?</p>
                </div>
                <div class="modal-footer">
                    <a href="<?= RUTA_HOME ?>controllers/user.php?action=delete&dni=<?= $_GET['dni'] ?>" class="btn btn-danger">Borrar</a>
                    <a href="<?= RUTA_HOME ?>admin/editar-usuario.php?dni=<?= $_GET['dni'] ?>" class=" btn btn-secondary" data-dismiss="modal">Cancelar</a>
                </div>
            </div>
        </div>
    </div> -->
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
                <a href="<?= RUTA_HOME ?>admin/editar-usuario.php" class="btn btn-primary">Añadir Usuario</a>
            </div>
        </div>
        <form action="<?= RUTA_HOME ?>controllers/user.php" method="POST">
            <div class="form-group">
                <label for="dni">dni</label>
                <input type="text" class="form-control <?= !empty($_SESSION['danger_alerts']['dni']) ? 'is-invalid' : '' ?>" id="dni" name="dni" <?= $updatingUser ? 'readonly' : '' ?> value="<?= $_SESSION['filled']['dni'] ?? $updatingUser ? $updatingUser->getDni() : '' ?>">
            </div>
            <div class="form-group">
                <label for="name">nombre</label>
                <input type="text" class="form-control <?= !empty($_SESSION['danger_alerts']['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= $_SESSION['filled']['name'] ?? $updatingUser ? $updatingUser->getName() : '' ?>">
            </div>
            <div class="form-group">
                <label for="surname">apellidos</label>
                <input type="text" class="form-control <?= !empty($_SESSION['danger_alerts']['surname']) ? 'is-invalid' : '' ?>" id="surname" name="surname" value="<?= $_SESSION['filled']['surname'] ?? $updatingUser ? $updatingUser->getSurname() : '' ?>">
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input type="email" class="form-control <?= !empty($_SESSION['danger_alerts']['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= $_SESSION['filled']['email'] ?? $updatingUser ? $updatingUser->getEmail() : '' ?>">
            </div>
            <div class="form-group">
                <label for="password">contraseña</label>
                <input type="password" class="form-control <?= !empty($_SESSION['danger_alerts']['password']) ? 'is-invalid' : '' ?>" id="password" name="password">
            </div>

            <?php if ($currentUser->getRol() == 'admin') : ?>
                <div class="form-group">
                    <label for="rol">Elige un rol</label>
                    <select class="form-control" name="rol" id="rol">
                        <option <?= $updatingUser ? ($updatingUser->getRol() == 'cliente' ? 'selected' : '') : '' ?> value="cliente">Cliente</option>
                        <option <?= $updatingUser ? ($updatingUser->getRol() == 'moderador' ? 'selected' : '') : '' ?> value="moderador">Moderador</option>
                        <option <?= $updatingUser ? ($updatingUser->getRol() == 'admin' ? 'selected' : '') : '' ?> value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status"></label>
                    <select class="form-control" name="status" id="status">
                        <option <?= $updatingUser ? ($updatingUser->getStatus() == 'active' ? 'selected' : '') : '' ?> value="active">activo</option>
                        <option <?= $updatingUser ? ($updatingUser->getStatus() == 'deleted' ? 'selected' : '') : '' ?> value="deleted">borrado</option>
                    </select>
                </div>
            <?php else : ?>
                <input type="hidden" name="rol" value="<?= $updatingUser->getRol() ?>">
                <input type="hidden" name="status" value="<?= $updatingUser->getStatus() ?>">
            <?php endif; ?>

            <input type="hidden" name="updating" value=<?= $updatingUser ? true : false ?>>
            <button name="action" value="save" type="submit" class="btn btn-primary font-weight-bold">Guardar</button>
        </form>
    </div>
    <!-- Aside right -->
    <?php require '../inc/layout/aside-right.php'; ?>
</div>


<?php
require '../inc/layout/footer.php';
?>