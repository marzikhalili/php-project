<?php

//refereces
require_once "includes/common.php";
require_once "classes/Auth.php";
Auth::protect();

// log out the user - the would be re directed to the login page
Auth::logout();
