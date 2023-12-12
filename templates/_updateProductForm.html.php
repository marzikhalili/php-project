<?php

// Include references (form helper functions)
require_once ROOT_DIR . "includes/form.php";

?>
<h2 class="subhead">Update a Product</h2>

<p class="messagebox">Please fill out the form to Update a product.</p>

<?php include "_formErrorSummary.html.php" ?>

<form class="forms" action="updateProduct.php" method="post" enctype="multipart/form-data" novalidate>
    <fieldset>
        <legend>Update product form</legend>

        <input type="hidden" name="itemId" value="<?= $product->getItemId() ?? 0 ?>">

        <div class="form-row">
            <label for="itemName">item Name:</label>
            <input type="text" name="itemName" id="itemName" maxlength="150" required autofocus <?= setValue("itemName") ?>>
        </div>

        <div class="form-row">
            <label for="photo">Photo:</label>
            <input type="file" name="photo" id="photo" maxlength="250">
        </div>

        <div class="form-row">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" min="1" aria-label="price" title="price" <?= setValue("price") ?>>
        </div>

        <div class="form-row">
            <label for="salePrice">Sale Price:</label>
            <input type="number" name="salePrice" id="salePrice" min="1" aria-label="salePrice" title="salePrice"
                <?= setValue("salePrice") ?>>
        </div>

        <div class="form-row">
            <label for="description">Description:</label>
            <textarea name="description" id="description" maxlength="2000" cols="30"
                rows="4"><?= setTextbox("description") ?></textarea>
        </div>

        <div class="form-row">
            <label for="featured">
                <input type="checkbox" name="featured" id="featured" value="spam" <?= setValue("featured") ?>>
                please check the Box if the Item is Available
            </label>
        </div>

        <div class="form-row dropdown">
            <label for="categoryId">Category:</label>
            <select name="categoryId" id="categoryId">
                <option value="1" <?= setSelected("categoryId", "1") ?>>Shoes</option>
                <option value="2" <?= setSelected("categoryId", "2") ?>>Helmets</option>
                <option value="3" <?= setSelected("categoryId", "3") ?>>Pants</option>
                <option value="4" <?= setSelected("categoryId", "4") ?>>Tops</option>
                <option value="5" <?= setSelected("categoryId", "5") ?>>Balls</option>
                <option value="6" <?= setSelected("categoryId", "6") ?>>Equipment</option>
                <option value="7" <?= setSelected("categoryId", "7") ?>>Training Gear</option>
            </select>
        </div>

        <div class="form-row">
            <button class="addProduct" type="submit" name="submitUpdateProduct">Update Product</button>
        </div>

    </fieldset>
</form>