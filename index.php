<?php
//Common includes for main PHP pages(controllers) 
require_once "includes/common.php";
//Home page - index.php
$title = "Home";

//step 0. start output buffering (capture output, dont display it yet)
ob_start();

$sql = <<<SQL
SELECT  itemId, itemName, price, salePrice, photo
FROM    item
LIMIT   0,5
SQL;

// Prepare the SQL statement
$stmt = $db->prepareStatement($sql);

// // Add/bind parameter values
// $stmt->bindValue(":search", "%$search%", PDO::PARAM_STR);

// Get the list of employees
$items = $db->executeSQL($stmt);

// 1. Include the page-specific content/template
include_once "templates/_homePage.html.php";

// Stop output buffering - store output in the $output variable
$output = ob_get_clean();

// 2. Include  the layout template (and inject content)  
include_once "templates/_layout.html.php";
