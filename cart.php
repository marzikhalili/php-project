<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "Shopping cart";

// Start output buffering (capture output, don't display it yet)
ob_start();

// Check if "add to cart" form has been submitted
if (isset($_POST["submitAddToCart"])) {

    // Form has been submitted - process form data

    // Get data passed to this page (in the $_POST super global array)
    $itemId = $_POST["itemId"] ?? 0;
    $quantity = $_POST["quantity"] ?? 0;

    // Clean up input data (e.g. trim)
    $itemId = intval($itemId);
    $quantity = intval($quantity);

    // Collection of all errors for this form (empty by default)
    $errors = [];

    // OPTIONAL: Validate quantity
    if ($quantity < 0) {
        $errors["quantity"] = "Quantity must be greater than zero.";
    }


    // Check that we have NO errors (otherwise just do nothing)
    if (count($errors) === 0) {

        try {
            // Valid: Add item to the shopping cart

            // Get product using the ID
            $product = new Product();
            $product->getProduct($itemId);


            // var_dump ($product -> getSalePrice());
            // exit;

            if ($product->getSalePrice() === 0 || $product->getSalePrice() === NULL) {

                $price = $product->getUnitPrice();

            } else {
                $price = $product->getSalePrice();
            }

            // Create a new CartItem
            $item = new CartItem($product->getProductName(), $quantity, $price, $itemId, $product->getPhoto());

            // Add item to the shopping cart
            $cart->addItem($item);

            // Save the shopping cart into the session!
            $_SESSION["cart"] = $cart;
        } catch (Exception $ex) {
            // Turn the exception into a nice error message
            $errors["cart"] = "Error adding to cart: " . $ex->getMessage();
        }

    }

}

// Check if "remove from cart" form has been submitted
else if (isset($_POST["submitRemoveFromCart"])) {

    // Remove item from the shopping cart

    // Get data passed to this page (in the $_POST super global array)
    $itemId = $_POST["itemId"] ?? 0;

    // Clean up input data (e.g. trim)
    $itemId = intval($itemId);

    // Collection of all errors for this form (empty by default)
    $errors = [];

    try {
        // Get product using the ID
        $product = new Product();
        $product->getProduct($itemId);

        // Create a new CartItem
        $item = new CartItem(
            $product->getProductName(),
            0,
            0,
            $itemId,
            $product->getPhoto()
        );

        // Remove item from the shopping cart
        $cart->removeItem($item);

        // Save the shopping cart into the session!
        $_SESSION["cart"] = $cart;
    } catch (Exception $ex) {
        // Turn the exception into a nice error message
        $errors["cart"] = "Error removing from cart: " . $ex->getMessage();
    }

}

// Display the shopping cart    
include_once "templates/_cartPage.html.php";

// Stop output buffering - store output in the $output variable
$output = ob_get_clean();

// Include the layout template (and inject content via $output)
include_once "templates/_layout.html.php";
