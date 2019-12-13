<?php


/** 
 * Change variables for title and description
 */
$pageTitle = "Editar Perfil";
$pageDescriprion = null;

require './inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['cliente', 'admin', 'moderador']);

?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <main>
            <section class="mb-5">
                <div class="row">
                    <h2>Datos personales</h2>
                </div>
                <form action="controllers/user.php" method="POST">
                    <div class="form-group">
                        <label for="dni">Tu dni</label>
                        <input type="text" class="form-control <?= !empty($_SESSION['danger_alerts']['dni']) ? 'is-invalid' : '' ?>" id="dni" name="dni" readonly value="<?= $_SESSION['filled']['dni'] ?? $currentUser->getDni() ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Tu nombre</label>
                        <input type="text" class="form-control <?= !empty($_SESSION['danger_alerts']['name']) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= $_SESSION['filled']['name'] ?? $currentUser->getName() ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="surname">Tus apellidos</label>
                        <input type="text" class="form-control <?= !empty($_SESSION['danger_alerts']['surname']) ? 'is-invalid' : '' ?>" id="surname" name="surname" value="<?= $_SESSION['filled']['surname'] ?? $currentUser->getSurname() ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Tu email</label>
                        <input type="email" class="form-control <?= !empty($_SESSION['danger_alerts']['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= $_SESSION['filled']['email'] ?? $currentUser->getEmail() ?? '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Tu contraseña</label>
                        <input type="password" class="form-control <?= !empty($_SESSION['danger_alerts']['password']) ? 'is-invalid' : '' ?>" id="password" name="password">
                    </div>

                    <?php if ($currentUser->getRol() == 'admin') : ?>
                        <div class="form-group">
                            <label for="rol">Elige un rol</label>
                            <select class="form-control" name="rol" id="rol">
                                <option <?= $currentUser->getRole() == 'cliente' ? 'selected' : '' ?> value="cliente">Cliente</option>
                                <option <?= $currentUser->getRole() == 'moderador' ? 'selected' : '' ?> value="moderador">Moderador</option>
                                <option <?= $currentUser->getRole() == 'admin' ? 'selected' : '' ?> value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Tu contraseña</label>
                            <select class="form-control" name="status" id="status">
                                <option <?= $currentUser->getRole() == 'activo' ? 'selected' : '' ?> value="activo">activo</option>
                                <option <?= $currentUser->getRole() == 'inactivo' ? 'selected' : '' ?> value="inactivo">inactivo</option>
                                <option <?= $currentUser->getRole() == 'borrado' ? 'selected' : '' ?> value="borrado">borrado</option>
                            </select>
                        </div>
                    <?php else : ?>
                        <input type="hidden" name="rol" value="<?= $currentUser->getRol() ?>">
                        <input type="hidden" name="status" value="<?= $currentUser->getStatus() ?>">
                    <?php endif; ?>

                    <input type="hidden" name="updating" value=true>
                    <button name="action" value="save" type="submit" class="btn btn-primary font-weight-bold">Guardar</button>
                </form>
            </section>
            <section class="mb-5">
                <div class="row">
                    <h2>Tus direcciones guardadas</h2>
                </div>
                <div class="row">
                    TODO:
                </div>
            </section>
        </main>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>