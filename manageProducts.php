<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "Manage Products";

// Start output buffering (capture output, don't display it yet)
ob_start();

// Check what action the page is performing (list items, add item, edit item, delete item, etc)
$action = $_GET["action"] ?? "";

// Add item
if (isset($_POST["submitAddCategory"])) {
    addItem();
}
// Delete item
else if (isset($_POST["submitDeleteProduct"])) {
    deleteItem();
}
// Edit item
else if (isset($_POST["submitEditProduct"])) {
    updateItem();
}
// Show add form
else if ($action === "add") {
    showAddForm();
}
// Show delete form
else if ($action === "delete") {
    showDeleteForm();
}
// Show edit form
else if ($action === "edit") {
    showEditForm();
}
// Show list of items
else {
    showList();
}

// Add item


// Delete item
function deleteItem()
{
    // Form has been submitted - process form data

    // Get data passed to this page
    $itemId = $_POST["itemId"] ?? "";

    // Clean up input data (e.g. trim)
    $itemId = intval($itemId);

    // Collection of all errors for this form (empty by default)
    $errors = [];

    // Validate ID
    if ($itemId === 0) {
        $errors["itemId"] = "item ID must be a valid integer.";
    }

    // TODO: Check if category has any products (if so, stop the delete!!)

    // Check for invalid data (errors)
    if (!empty($errors)) {

        // Invalid: Display the list with error messages
        include_once "templates/_manageProductsPage.html.php";
    } else {

        // Valid: Delete the category from the database & display confirmation

        // Build a new category
        $product = new Product();

        // Delete the category
        if ($product->deleteProduct($itemId)) {

            // Display success message
            $successMessage = "Product deleted successfully.";
            include_once "templates/_success.html.php";
        } else {

            // Display error message
            $errorMessage = "Product could not be deleted, try again.";
            include_once "templates/_error.html.php";
        }
    }
}


function updateItem()
{
    $itemId = $_POST["itemId"] ?? "";

    // Clean up input data (e.g. trim)
    $itemId = intval($itemId);

    // Collection of all errors for this form (empty by default)
    $errors = [];

    // Validate ID
    if ($itemId === 0) {
        $errors["itemId"] = "item ID must be a valid integer.";
    }


    // Check for invalid data (errors)
    if (!empty($errors)) {

        // Invalid: Display the list with error messages
        include_once "templates/_manageProductsPage.html.php";
    } else {

        // Valid: Delete the category from the database & display confirmation

        // Build a new category
        $product = new Product();

        // Delete the category
        if ($product->updateProduct($itemId)) {

            // Display success message
            $successMessage = "Product deleted successfully. ";
            include_once "templates/_success.html.php";
        } else {

            // Display error message
            $errorMessage = "Product could not be deleted, try again. ";
            include_once "templates/_error.html.php";
        }
    }
}

// Show add form
function showAddForm()
{

    // Display the form
    include_once "templates/_addProductForm.html.php";
}

// Show delete form
function showDeleteForm()
{

    // Get category ID
    $itemId = intval($_GET["itemId"] ?? 0);

    // Check for no ID
    if ($itemId === 0) {

        // Display main listing with error
        $errors["item"] = "item ID does not exist!";
        include_once "templates/_manageProductsPage.html.php";

        // "Guard clause" = early exit
        return;
    }

    // Get the item
    $product = new Product();
    $product->getProduct($itemId);

    // if ($category->getCategoryId())

    // Display the form
    include_once "templates/_deleteProductForm.html.php";
}
function showEditForm()
{
    $itemId = intval($_GET["itemId"] ?? 0);

    // Check for no ID
    if ($itemId === 0) {

        // Display main listing with error
        $errors["item"] = "item ID does not exist!";
        include_once "templates/_manageProductsPage.html.php";

        // "Guard clause" = early exit
        return;
    }

    // Get the item
    $product = new Product();
    $product->getProduct($itemId);


    // if ($category->getCategoryId())

    // Display the form
    include_once "templates/_updateProductForm.html.php";
}
// Show list of items
function showList()
{

    // Display the list of items
    include_once "templates/_manageProductsPage.html.php";
}

// Stop output buffering - store output in the $output variable
$output = ob_get_clean();

// Include the layout template (and inject content via $output)
include_once "templates/_layout.html.php";
