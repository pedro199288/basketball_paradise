<div>
    <nav aria-label="...">
        <ul class="pagination">
            <?php if ($pag != 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_SERVER['PHP_SELF'] . "?pag=" . ($pag - 1) ?>" tabindex="-1">Anterior</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPags; $i++) : ?>
                <li class="page-item <?= $pag == $i ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $_SERVER['PHP_SELF'] . "?pag=" . ($i) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <?php if ((int) $pag != $totalPags) : ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_SERVER['PHP_SELF'] . "?pag=" . ($pag + 1) ?>">Siguiente</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>