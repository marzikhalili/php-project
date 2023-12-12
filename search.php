<?php

    // Common includes for main PHP pages (controllers)
    require_once "includes/common.php";

    // Config
    $title = "Search results";

    // Start output buffering (capture output, don't display it yet)
    ob_start();

    // Check if search keyword has been provided
    if (isset($_GET["search"])) {

        // Get the search value
        $search = $_GET["search"];

        // Search for products
        $sql = <<<SQL
            SELECT  itemId, itemName, price, salePrice, description, photo 
            FROM    item
            WHERE   itemName LIKE :search
        SQL;

        // Prepare the SQL statement
        $stmt = $db->prepareStatement($sql);

        // Add/bind parameter values
        $stmt->bindValue(":search", "%$search%", PDO::PARAM_STR);

        // Get the list of products
        $items = $db->executeSQL($stmt);

        // Include the page-specific content/template
        include_once "templates/_searchPage.html.php";

    } else {

        // Display error
        $errorMessage = "Please specify a search query: 'search' parameter missing.";
        include_once "templates/_error.html.php";

    }

    // Stop output buffering - store output in the $output variable
    $output = ob_get_clean();

    // 2. Include the layout template (and inject content via $output)
    include_once "templates/_layout.html.php";
    