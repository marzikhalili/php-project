<?php

    // Common includes for main PHP pages (controllers)
    require_once "includes/common.php";

    // Config
    $title = "Products";

    // Start output buffering (capture output, don't display it yet)
    ob_start();

     // Search for items
     $sql = <<<SQL
     SELECT  itemId, itemName, price, salePrice, photo
     FROM    item
     SQL;

 // Prepare the SQL statement
    $stmt = $db->prepareStatement($sql);

 // // Add/bind parameter values
 // $stmt->bindValue(":search", "%$search%", PDO::PARAM_STR);

 // Get the list of employees
    $items = $db->executeSQL($stmt);


    // 1. Include the page-specific content/template
    include_once "templates/_viewproductPage.html.php";

    // Stop output buffering - store output in the $output variable
    $output = ob_get_clean();

    // 2. Include the layout template (and inject content via $output)
    include_once "templates/_layout.html.php";
    