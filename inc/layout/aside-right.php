<div class="col">
    <?php if (!$currentUser) : ?>
        <form action="controllers/user.php" method="POST">
            <div class="form-group">
                <label for="loginEmail">Tu email</label>
                <input type="email" class="form-control  <?= !empty($_SESSION['danger_alerts']['loginEmail']) ? 'is-invalid' : '' ?>" id="loginEmail" name="loginEmail" value="<?= $_SESSION['filled']['loginEmail'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label for="loginPassword">Tu contraseña</label>
                <input type="password" class="form-control  <?= !empty($_SESSION['danger_alerts']['loginPassword']) ? 'is-invalid' : '' ?>" id="loginPassword" name="loginPassword" value="<?= $_SESSION['filled']['loginPassword'] ?? '' ?>">
            </div>
            <div class="form-group">
                <a href="registro.php">Regístrate aquí</a>
            </div>
            <button name="action" value="login" type="submit" class="btn btn-primary btn-block font-weight-bold">Login</button>
        </form>
    <?php else: ?>
        <p><b>Bienvenido</b>, <?= $currentUser->getName() ?? $currentUser->getEmail() ?></p>
        <div>
            <a class="btn btn-primary" href="<?= $_SERVER['PHP_SELF'] ?>?logout">Cerrar sesión</a>
            <a class="nav-link" href="editar-usuario.php">Editar perfil</a>
            <a class="nav-link" href="pedidos.php">Mis Pedidos</a>
            <a class="nav-link" href="direcciones.php">Mis direcciones</a>
        </div>

        <?php if($currentUser->getRol() != 'cliente'): ?>
            <!-- TODO: Funcionalidades de moderador/admin -->
        <?php endif; ?>

    <?php endif; ?>
</div>