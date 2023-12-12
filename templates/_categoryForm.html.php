<?php

// Include references (form helper functions)
require_once ROOT_DIR . "includes/form.php";

?><h2 class="subhead"> update A Category</h2>

<p class="messagebox">Please select the category you want to edit.</p>

<?php include "_formErrorSummary.html.php" ?>

<form action="updateCategory.php" method="post" novalidate>
    <fieldset>

        <div class="form-row dropdown">
            <label for="categoryId">Category Name:</label>
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
            <button class="addProduct" type="submit" name="submitAddCategory">Update Category</button>
        </div>

    </fieldset>
</form>