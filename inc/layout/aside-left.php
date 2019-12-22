<div class="col">
    <h5>Categorías</h5>
    <div class="mb-4">
        <?php
        // Get all categories to show in the select as optgroup
        $mainCategories = Category::getAll(true);
        foreach ($mainCategories as $mainCategory) : ?>
            <a class="nav-link pl-0 font-weight-bold" href="<?= RUTA_HOME ?>productos.php?c=<?= $mainCategory->getId() ?>"><?= $mainCategory->getName() ?></a>
            <?php
            $subcategories = $mainCategory->getSubcategories();
            if (!isset($subcategories['type'])) {
                foreach ($subcategories as $secondaryCategory) : ?>
                    <a class="nav-link" href="<?= RUTA_HOME ?>productos.php?c=<?= $secondaryCategory->getId() ?>"><?= $secondaryCategory->getName() ?></a>
            <?php endforeach;
            }
        endforeach;
        ?>
        <h6 class="mt-3">Otras Categorías</h6>
        <?php
        $categoriesWithoutParentNotMain = Category::getAllWithoutParentNotMain();
        foreach ($categoriesWithoutParentNotMain as $category):
            ?>
            <a class="nav-link" href="<?= RUTA_HOME ?>productos.php?c=<?= $category->getId() ?>"><?= $category->getName() ?></a>
        <?php
        endforeach;
        ?>
    </div>
</div>