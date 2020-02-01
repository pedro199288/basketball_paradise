<div class="col ml-2">
    <?php if ($currentCart) : ?>
        <div class="row">
            <h5>Carrito</h5>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-right" title="cantidad">Cant.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalQtty = 0;
                    $totalPrice = 0;
                    foreach ($currentCart as $productId => $quantity) :
                        $cartProduct = Product::getById($productId);
                        $totalQtty += $quantity;
                        $totalPrice += ($cartProduct->getPrice() * $quantity);
                    ?>
                        <tr>
                            <td><?= $cartProduct->getName() ?></td>
                            <td class="text-right"><?= $quantity ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="font-weight-bold">Unidades totales:</td>
                        <td class="text-right"><?= $totalQtty ?></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Precio total:</td>
                        <td class="text-right"><?= $totalPrice ?>€</td>
                    </tr>
                </tbody>
            </table>
            <div class="col-12">
                <a href="ver-carrito.php" class="btn btn-primary d-block mx-auto mb-3">Ir al carrito</a>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!$currentUser) : ?>
        <form action="controllers/user.php" method="POST" id="user-login">
            <div class="form-group">
                <label for="loginEmail">Tu email</label>
                <input type="email" class="form-control  <?= !empty($_SESSION['danger_alerts']['loginEmail']) ? 'is-invalid' : '' ?>" id="loginEmail" name="loginEmail" value="<?= $_SESSION['filled']['loginEmail'] ?? '' ?>">
            </div>
            <div class="form-group">
                <label for="loginPassword">Tu contraseña</label>
                <input type="password" class="form-control  <?= !empty($_SESSION['danger_alerts']['loginPassword']) ? 'is-invalid' : '' ?>" id="loginPassword" name="loginPassword" value="<?= $_SESSION['filled']['loginPassword'] ?? '' ?>">
            </div>
            <div class="form-group">
                <a href="<?= RUTA_HOME ?>registro.php">Regístrate aquí</a>
            </div>
            <button name="action" value="login" type="submit" class="btn btn-primary btn-block font-weight-bold">Login</button>
        </form>
    <?php else : ?>
        <p><b>Bienvenido</b>, <?= $currentUser->getName() ?? $currentUser->getEmail() ?></p>
        <div class="mb-4">
            <a class="nav-link" href="<?= RUTA_HOME ?>editar-usuario.php">Editar perfil</a>
            <a class="nav-link" href="<?= RUTA_HOME ?>mis-pedidos.php">Mis Pedidos</a>
            <a class="btn btn-secondary d-block mt-3 mx-auto" href="<?= $_SERVER['PHP_SELF'] ?>?logout">Cerrar sesión</a>
        </div>

        <?php if ($currentUser->getRol() != 'cliente') : ?>
            <h5>Opciones de Administrador</h5>
            <div class="mb-4">
                <a class="nav-link" href="<?= RUTA_HOME ?>admin/categorias.php">Administrar Categorías</a>
                <a class="nav-link" href="<?= RUTA_HOME ?>admin/productos.php">Administrar Productos</a>
                <a class="nav-link" href="<?= RUTA_HOME ?>admin/ofertas.php">Administrar Ofertas</a>
                <a class="nav-link" href="<?= RUTA_HOME ?>admin/pedidos.php">Administrar Pedidos</a>
                <?php if ($currentUser->getRol() == 'admin') : ?>
                    <a class="nav-link" href="<?= RUTA_HOME ?>admin/usuarios.php">Administrar Usuarios</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>