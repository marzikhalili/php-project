<?php

    // Common includes for main PHP pages (controllers)
    require_once "includes/common.php";

    // Config
    $title = "Products by category";

    // Start output buffering (capture output, don't display it yet)
    ob_start();

    // Check if category ID has been provided
    if (isset($_GET["id"])) {

        // Validate/sanitise the ID (force as int)
        $categoryId = intval($_GET["id"]);

        // Search for the category in the database
        $sql = <<<SQL
            SELECT  categoryName
            FROM    category
            WHERE   categoryId = :categoryId
        SQL;

        // // Execute query
        // $rows = $pdo->query($sql);

        // // Get the category name out of the returned data
        // $categoryName = $rows->fetchColumn();

        // Prepare the SQL statement
        $stmt = $db->prepareStatement($sql);

        // Add/bind parameter values
        $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);

        // Get the category name out of the returned data
        $categoryName = $db->executeSQLReturnOneValue($stmt);

        // Check if category does NOT exist
        if ($categoryName === false) {

            // Display error
            $errorMessage = "Category does not exist.";
            include_once "templates/_error.html.php";

        } else {

            // Load the category's products
            $sql = <<<SQL
                SELECT  itemId, itemName, price, description,salePrice, photo
                FROM    item
                WHERE   categoryId = :categoryId
            SQL;

            // Prepare the SQL statement
            $stmt = $db->prepareStatement($sql);

            // Add/bind parameter values
            $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);

            // Get the list of products
            $items = $db->executeSQL($stmt);

            // Include the page-specific content/template
            include_once "templates/_categoryPage.html.php";

        }

    } else {

        // You COULD redirect the user
        // header("Location: index.php");
        // exit;

        // Display error
        $errorMessage = "Please select a valid category: 'id' parameter missing.";
        include_once "templates/_error.html.php";

    }

    // Stop output buffering - store output in the $output variable
    $output = ob_get_clean();

    // 2. Include the layout template (and inject content via $output)
    include_once "templates/_layout.html.php";
    