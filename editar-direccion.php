<?php

/**
 * Change variables for title and description
 */
$pageTitle = "Editar direccion";
$pageDescriprion = null;

require './inc/layout/header.php';

// check permissions
checkPermisos($currentUser, ['cliente', 'admin', 'moderador']);


$address = false;
if (isset($_GET['id'])) {
    $addressId = $_GET['id'] ?? null;
    $addresses = $currentUser->getAddresses();
    $address = array_filter($addresses, function ($a) use ($currentUser, $addressId) {
        return $a['id'] == $addressId;
    })[0];
    // var_dump($address);
    // die();
}



if (isset($_GET['action']) && $_GET['action'] == 'delete') :
?>

    <div class="modal" style="display: block" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Borrar dirección?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de borrar esta dirección?</p>
                </div>
                <div class="modal-footer">
                    <a href="<?= RUTA_HOME ?>controllers/user.php?action=delete_address&id=<?= $address['id'] ?>" class="btn btn-danger">Borrar</a>
                    <a href="<?= RUTA_HOME ?>editar-usuario.php" class=" btn btn-secondary" data-dismiss="modal">Cancelar</a>
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
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <div class="row">
            <h4><?= $address ? 'Editar' : 'Añadir' ?> Dirección</h4>
        </div>
        <form action="<?= RUTA_HOME ?>controllers/user.php" method="POST">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $address ? $address['name'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="surname">Apellidos</label>
                <input type="text" class="form-control" id="surname" name="surname" value="<?= $address ? $address['surname'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="address">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= $address ? $address['address'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="postal_code">Código postal</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?= $address ? $address['postal_code'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="location">Localidad</label>
                <input type="text" class="form-control" id="location" name="location" value="<?= $address ? $address['location'] : '' ?>">
            </div>
            <div class="form-group">
                <label for="province">Provincia</label>
                <input type="text" class="form-control" id="province" name="province" value="<?= $address ? $address['province'] : '' ?>">
            </div>

            <input type="hidden" name="id" value=<?= $address ?  $address['id'] : null ?>>
            <input type="hidden" name="updating" value=<?= $address ? true : false ?>>
            <button name="action" value="save_address" type="submit" class="btn btn-primary font-weight-bold">Guardar</button>
        </form>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>