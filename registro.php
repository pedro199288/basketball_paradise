<?php

/** 
 * Change variables for title and description
 */
$pageTitle = "Registro de usuario";
$pageDescriprion = null;

require './inc/layout/header.php';

?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">

    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <form action="controllers/user.php" method="POST">
            <div class="form-group">
                <label for="dni">Tu dni</label>
                <input type="text" class="form-control <?= !empty($_SESSION['danger_alerts']['dni']) ? 'is-invalid' : '' ?>" id="dni" name="dni" value="<?= $_SESSION['filled']['dni'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label for="email">Tu email</label>
                <input type="email" class="form-control <?= !empty($_SESSION['danger_alerts']['email']) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= $_SESSION['filled']['email'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label for="password">Tu contraseña</label>
                <input type="password" class="form-control <?= !empty($_SESSION['danger_alerts']['password']) ? 'is-invalid' : '' ?>" id="password" name="password">
            </div>
            <div class="form-group">
                <a href="index.php">Volver a inicio</a>
            </div>
            <button name="action" value="save" type="submit" class="btn btn-primary font-weight-bold">Enviar</button>
        </form>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>