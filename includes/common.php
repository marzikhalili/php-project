<?php

/* 
 * Common includes for all main PHP pages (controllers)
 */

// Set the root directory of the project
// This will help with includes
// Get the parent of the current dir and store in ROOT_DIR constant
define("ROOT_DIR", dirname(__DIR__) . '/');

// Pull in class definitions
require_once ROOT_DIR . "classes/CartItem.php";
require_once ROOT_DIR . "classes/ShoppingCart.php";
require_once ROOT_DIR . "classes/Category.php";
require_once ROOT_DIR . "classes/Product.php";

//satrt a session (if its not already started)
if (!isset($_SESSION)) {
    session_start();
}
// Database connection (create an instance of the DBAccess class)
// $db is the DBAccess instance
require "database.php";

// Open database connection
$db->connect();

// Get shopping cart from the session (create a new cart if one doesnt exist )
$cart = $_SESSION["cart"] ?? new ShoppingCart();