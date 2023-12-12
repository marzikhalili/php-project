<?php

//navigation items as an array 
$navigationLinks = [
    // "page.php" => "Nav text",
    "index.php" => "Home",
    "aboutsw.php" => "About Us",
    "contactUs.php" => "Contact Us",
    "viewProducts.php" => " View Products",

];

//get the curently loaded PHP page/ script, e.g. index.php
// print_r($_SERVER["SCRIPT_NAME"]); =get the currently loaded PHP script
// basename(path) gets the last section of the path (i.e. just the file name)
$currentPage = basename($_SERVER["SCRIPT_NAME"]);

?>

<ul class="nav-menu">
    <!-- loop starts here  -->
    <?php foreach ($navigationLinks as $linkHref => $linkText): ?>
        <li class="nav-item <?= $currentPage === $linkHref ? "nav-item--active" : "" ?>">
            <a class="nav-link" href="<?= $linkHref ?>">
                <?= $linkText ?>
            </a>
        </li>
        <!-- loop end here -->
    <?php endforeach ?>
</ul>