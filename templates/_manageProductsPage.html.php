<?php

// Include references (form helper functions)
require_once ROOT_DIR . "includes/form.php";

// Build category object
$product = new Product();

?><h2 style="display: flex; justify-content: center; align-itens: center; margin:10px; font-weight:bold; color:#00aced">Manage Products</h2>



<?php include "_formErrorSummary.html.php" ?>

<p class="manageList">
    <a class="link-blue" href="addProduct.php">➕ Add new product</a>
</p>


<?php if ($product->getNumberOfProducts() === 0) : ?>

<p>No products to display, please add one.</p>

<?php else : ?>

<div class="manageList">
<?php foreach ($product->getProducts() as $item) : ?>

    <div><?= $item["itemId"] ?></div>
    <div><?= $item["itemName"] ?></div>
    <div><?= $item["price"] ?></div>
    <div>
        <!-- <a href="manageCategories.php?action=edit&id=xxx">Edit</a> -->
        <form action="manageProducts.php" method="get">
            <input type="hidden" name="itemId" value="<?= $item["itemId"] ?>">
            <button class="btnEdit" type="submit" name="action" value="edit">Edit</button>
            <button class="btnRemove" type="submit" name="action" value="delete">Delete</button>
        </form>
    </div>


<?php endforeach ?>
</div>

<p><strong>Total Products: <?= $product->getNumberOfProducts() ?></strong></p>

<?php endif ?>