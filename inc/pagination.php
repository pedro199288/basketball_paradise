<div>
    <nav aria-label="...">
        <ul class="pagination">
        <li class="page-item <?= $pag == 1 ? 'disabled' : '' ?>">
            <a class="page-link"  href="<?= $_SERVER['PHP_SELF']."?pag=". ($pag-1) ?>" tabindex="-1">Anterior</a>
        </li>
        <?php for($i = 1; $i <= $totalPags; $i++): ?>
            <li class="page-item <?= $pag == $i ? 'active': '' ?>">
            <a class="page-link" href="<?= $_SERVER['PHP_SELF']."?pag=". ($i) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= (int) $pag == $totalPags ? 'disabled' : '' ?>">
            <a class="page-link"  href="<?= $_SERVER['PHP_SELF']."?pag=". ($pag+1) ?>">Siguiente</a>
        </li>
        </ul>
    </nav>
</div>