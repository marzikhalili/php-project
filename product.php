<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "product details";

// Start output buffering (capture output, don't display it yet)
ob_start();
if (isset($_GET["id"])) {

    // Validate/sanitise the ID (force as int)
    $itemId = intval($_GET["id"]);

    // Search for the item in the database
    $sql = <<<SQL
            SELECT	itemId, itemName, price, salePrice, description, photo 
            FROM	item
            WHERE	itemId = :itemId
        SQL;

    // Prepare the SQL statement
    $stmt = $db->prepareStatement($sql);

    // Add/bind parameter values
    $stmt->bindValue(":itemId", $itemId, PDO::PARAM_INT);

    // Get the item name out of the returned data
    $items = $db->executeSQL($stmt);

    // Check if item does NOT exist
    if (empty($items)) {

        // Display error
        $errorMessage = "item does not exist.";
        include_once "templates/_error.html.php";
    } else {

        // Extract the first (and only) row of data
        $item = $items[0];

        // Include the page-specific content/template
        include_once "templates/_productPage.html.php";
    }
} else {

    // Display error
    $errorMessage = "Please select a valid item: 'id' parameter missing.";
    include_once "templates/_error.html.php";
}

// Stop output buffering - store output in the $output variable
$output = ob_get_clean();

// 2. Include the layout template (and inject content via $output)
include_once "templates/_layout.html.php";
