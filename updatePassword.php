<?php
require_once "classes/Auth.php";
require_once "includes/common.php";

$password = new $password();
$categoryRows = $category->getCategories();

if (!isset($_SESSION)) {
  session_start();
}

$title = "Update password";


$message = "";

if (!empty($_POST["newPassword"])) {
  // add user
  Auth::updatePassword($_POST["newPassword"]);
}

// start buffer
ob_start();

// display create user form
include "templates/_updatePassword.html.php";

$output = ob_get_clean();

include "templates/_layout.html.php";