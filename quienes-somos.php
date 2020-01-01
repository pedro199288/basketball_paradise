<?php

/** 
 * Change variables for title and description
 */
$pageTitle = "Quiénes Somos - Basketball Paradise";
$pageDescriprion = "";

require './inc/layout/header.php';


?>

<div class="row justify-content-center">
    <h1 class="border-bottom pb-3 mb-3"><?= $pageTitle ?></h1>
</div>
<div class="row">
    <!-- Aside left -->
    <?php require './inc/layout/aside-left.php'; ?>
    <div class="col-md-7 border-right">
        <h2>Quienes somos</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim perspiciatis at ipsum incidunt corporis, eveniet et voluptatem molestiae ipsa aperiam harum, ullam molestias explicabo mollitia accusamus labore unde asperiores? Maiores.</p>
    </div>
    <!-- Aside right -->
    <?php require './inc/layout/aside-right.php'; ?>
</div>


<?php
require './inc/layout/footer.php';
?>