<?php

//navigation items as an array 
$navigationLinks = [
  // "page.php" => "Nav text",
  "manageUser.php" => " Manage User",
  "manageProducts.php" => " Manage Products",
  "manageCategories.php" => " Manage categories"


];

//get the curently loaded PHP page/ script, e.g. index.php
// print_r($_SERVER["SCRIPT_NAME"]); =get the currently loaded PHP script
// basename(path) gets the last section of the path (i.e. just the file name)
$currentPage = basename($_SERVER["SCRIPT_NAME"]);

?>

<ul class="protected-nav">
  <!-- loop starts here  -->
  <?php foreach ($navigationLinks as $linkHref => $linkText): ?>
    <li class="protected-item <?= $currentPage === $linkHref ? "nav-item--active" : "" ?>">
      <a class="protected-link" href="<?= $linkHref ?>">
        <?= $linkText ?>
      </a>
    </li>
    <!-- loop end here -->
  <?php endforeach ?>
</ul>