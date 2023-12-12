<?php
//Common includes for main PHP pages(controllers) 
require_once"includes/common.php";
//Home page - index.php
$title = "About SW";

//step 0. start output buffering (capture output, dont display it yet)
ob_start();

// 1. Include the page-specific content/template
include_once"templates/_aboutsw.html.php";

// Stop output buffering - store output in the $output variable
$output = ob_get_clean();

// 2. Include  the layout template (and inject content)  
include_once"templates/_layout.html.php";