<?php
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
?>


<div class="category_nav">
<ul class="category-nav-list">
    <!-- loop starts here  -->
    <?php foreach($categories as $category): ?>
    <li class="category-nav-item">
    <a class="nav__link" href="category.php?id=<?= $category["categoryId"]?>"> <?= $category["categoryName"]?></a>
    </li>
    
    <!-- loop end here -->
<?php endforeach ?>
</ul>
</div>