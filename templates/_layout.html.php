<?php
// determine the page theme (body class)
$_SESSION["theme"] = "";
//GET the chosen theme from the session 
$theme = $_SESSION["theme"] ?? "default";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? "Undifined Document" ?> - sportswarehouse
    </title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="page-<?= basename($_SERVER["SCRIPT_NAME"], ".php") ?> theme-<?= $theme ?>">
    <div class="site-wrapper wrapper">
        <header class="site-header">

            <div class="menu">
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <nav class="navbar wrapper">
                    <div class="navseperator">
                        <?php include "_navigation.html.php"; ?>
                        <div>
                            <ul class="nav-menu-right">
                                <?php include "_rightNavigation.html.php"; ?>
                                <li class="nav-item">
                                    <?php
                                    // $num_items = $_SESSION["cart"]->counter();
                                    $num_items=isset($_SESSION["cart"]) ? $_SESSION["cart"] ->counter() : 0;
                                    ?>
                                    <button class="itemholder"><?= $num_items ?> items</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <main class="main-content wrapper">
            <div class="search-logo-container">
                <div class="logo">
                    <a href="index.php"><img src="assets/sports-warehouse-logo-600.png" width="600" height="82"
                            alt="sports-warehouse-logo" /></a>
                </div>

                <form class="search" action="search.php" method="get">
                    <input class="search__input" type="search" name="search" aria-label="Product Search"
                        placeholder="Search  producs ">
                    <button type="submit" class="search__submit"><img src="assets/search-icon.png"
                            alt="search-icon"></button>
                </form>
            </div>
            <?php include "_navigationProducts.html.php" ?>
            <?= $output ?? 'NO TEMPLATE CONTENT - $output not defined' ?>
        </main>
    </div>
    <footer class="footer bg">
        <?php include "_navigationFooter.html.php" ?>
    </footer>
    <div class="copyright" style="display: flex; justify-content: center; align-items: center; margin:5px">
        <p>&copy; Copyright 2020 Sports Warehouse.
            All rights reserved.
            Website made by Awesomesauce Design.
        </p>
    </div>
    <script src="script/script.js"></script>
</body>

</html>