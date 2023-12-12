<?php

//navigation items as an array 
$navigationLinks = [
    "logout.php" => "logout",
    "login.php" => "login",
    "cart.php" => "viewCart",
];

//get the curently loaded PHP page/ script, e.g. index.php
// print_r($_SERVER["SCRIPT_NAME"]); =get the currently loaded PHP script
// basename(path) gets the last section of the path (i.e. just the file name)
$currentPage = basename($_SERVER["SCRIPT_NAME"]);

?>
<!-- loop starts here  -->
<?php foreach ($navigationLinks as $linkHref => $linkText) : ?>
    <li class="nav-item <?= $currentPage === $linkHref ? "nav-item--active" : "" ?>">
        <img class="cart" src="assets/<?= $linkText ?>.png" alt="<?= $linkText ?>" />
        <a class="nav-link" href="<?= $linkHref ?>"><?= $linkText ?></a>
    </li>
    <!-- loop end here -->
<?php endforeach ?>