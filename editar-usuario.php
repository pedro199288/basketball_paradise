<?php


/** 
 * Change variables for title and description
 */
$pageTitle = "Editar Perfil";
$pageDescriprion = null;

require './inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['cliente', 'admin', 'moderador']);
$addresses = $currentUser->getAddresses() ?? null;

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
                                <option <?= $currentUser->getRol() == 'cliente' ? 'selected' : '' ?> value="cliente">Cliente</option>
                                <option <?= $currentUser->getRol() == 'moderador' ? 'selected' : '' ?> value="moderador">Moderador</option>
                                <option <?= $currentUser->getRol() == 'admin' ? 'selected' : '' ?> value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status"></label>
                            <select class="form-control" name="status" id="status">
                                <option <?= $currentUser->getRol() == 'active' ? 'selected' : '' ?> value="active">activo</option>
                                <option <?= $currentUser->getRol() == 'deleted' ? 'selected' : '' ?> value="deleted">borrado</option>
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
                    <div class="col-12 d-flex justify-content-between mb-3">
                        <h4>Direcciones</h4>
                        <a href="<?= RUTA_HOME ?>editar-direccion.php" class="btn btn-primary">Añadir Dirección</a>
                    </div>
                </div>
                <div class="row">
                    <?php if ($addresses) : ?>
                        <table class="table table-striped table-hover table-responsive col-12 w-100">
                            <thead>
                                <tr>
                                    <th scope="col">number</th>
                                    <th scope="col">nombre</th>
                                    <th scope="col">apellidos</th>
                                    <th scope="col">dirección</th>
                                    <th scope="col">acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($addresses as $address) : ?>
                                    <tr>
                                        <th scope="row"><?= $address['address_number'] ?></th>
                                        <td><?= $address['name'] ?></td>
                                        <td><?= $address['surname'] ?></td>
                                        <td>
                                            <p><?= $address['address'] ?></p>
                                            <p><?= $address['postal_code'] ?></p>
                                            <p><?= $address['location'] ?></p>
                                            <p><?= $address['province'] ?></p>
                                        </td>
                                        <td>
                                            <a class="btn btn-secondary" href="<?= RUTA_HOME ?>editar-direccion.php?id=<?= $address['id'] ?>">Editar</a>
                                            <a class="btn btn-danger" href="<?= RUTA_HOME ?>editar-direccion.php?action=delete&id=<?= $address['id'] ?>">Borrar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p>No hay direcciones guardadas</p>
                    <?php endif; ?>

                </div>
            </section>
            <section class="mb-5">
                <div class="row">
                    <h2>Darme de baja</h2>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-between mb-3">
                        <a href="<?= RUTA_HOME ?>controllers/user.php?action=delete&dni=<?=$currentUser->getDni()?>" class="btn btn-primary">Darse de baja</a>
                    </div>
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