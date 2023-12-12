<?php
$navigationLinks = [
    // "page.php" => "Nav text",
    "index.php" => "Home",
    "aboutsw.php" => "About SW",
    "contactUs.php" => "Contact Us",
    "viewProducts.php" => "view Products",
    "privacy.php" => "Privacy Policy",
];

$sql = <<<SQL
SELECT  categoryId, categoryName
FROM    category
SQL;

// // Execute query (get categories from the database)
// $categories = $pdo->query($sql);

// Prepare the SQL statement
$stmt = $db->prepareStatement($sql);

// Execute query (get categories from the database)
$categories = $db->executeSQL($stmt);

$navigationsociallinks = [
    "index.php"=> "Facebook",
    "#.php"=> "twitter",
    "#1.php"=> "other",
] ;

//get the curently loaded PHP page/ script, e.g. index.php
// print_r($_SERVER["SCRIPT_NAME"]); =get the currently loaded PHP script
// basename(path) gets the last section of the path (i.e. just the file name)
$currentPage = basename($_SERVER["SCRIPT_NAME"]);
?>

<div class="footer-container">
    <div class="row">

        <div class="footer-col col--blue">
            <div class="footer-col-inner">
                <div class="footer-heading">
                    <h2>Site navigation</h2>
                </div>
                <ul>
                    <?php foreach($navigationLinks as $linkHref => $linkText): ?>
                    <li class="nav-list <?= $currentPage === $linkHref ? "nav-item--active-blue": "" ?>">
                        <div class="bullet"></div>
                        <a class="nav__item" href="<?=$linkHref?>"><?=$linkText?></a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>

        <div class="footer-col col--orange">
            <div class="footer-col-inner">
                <div class="footer-heading">
                    <h2>Products category</h2>
                </div>
                <ul>
                    <?php foreach($categories as $category): ?>
                    <li class="nav-list">
                        <div class="bullet"></div>
                        <a class="nav__item" href="category.php?id=<?= $category["categoryId"]?>">
                            <?= $category["categoryName"]?></a>
                    </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>


        <!-- temporaryli fix to be corrected later  -->
        <div class="footer-col col--blue">
            <div class="footer-col-inner">
                <div class="footer-heading">
                    <h2 class="subheading">Contact Sports Warehouse</h2>
                </div>
                <div class="social-links">
                    <span class="social-cards">
                        <a href="#">
                            <span class="image-icon">
                                <img src="assets/facebook-icon.png" width="22" height="34" alt="facebook-icon" />
                            </span>
                            <span class="social-links-description">facebook</span>
                        </a>
                    </span>

                    <span class="social-cards">
                        <a href="#">
                            <span class="image-icon">
                                <img src="assets/twitter-icon.png" width="39" height="32" alt="twitter-icon" />
                            </span>
                            <span class="social-links-description">twitter</span>
                        </a>
                    </span>

                    <span class="social-cards">
                        <a href="#">
                            <span class="image-icon">
                                <img src="assets/other-icon.png" width="44" height="45" alt="other-icon" />
                            </span>
                            <span class="social-links-description">other</span>
                        </a>
                    </span>
                </div>
                <div class="other-link">
                    <div class="other-links-wrapper">
                        <ul>
                            <li><a class="other-links" href="#">online form</a></li>
                            <li><a class="other-links" href="#">Email</a></li>
                            <li><a class="other-links" href="#">Phone</a></li>
                            <li><a class="other-links" href="#">Address</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>