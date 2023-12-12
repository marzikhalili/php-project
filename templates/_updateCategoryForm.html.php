<?php

// Include references (form helper functions)
require_once ROOT_DIR . "includes/form.php";

?><h2 class="subhead">Add a new category</h2>

<p class="messagebox">Please fill out the form to add a new category.</p>

<?php include "_formErrorSummary.html.php" ?>

<form action="manageCategories.php" method="post" enctype="multipart/form-data" novalidate>
    <fieldset>
        <legend>update category</legend>

        <div class="form-row">
        <input type="hidden" name="categoryId" value="<?= $category->getCategoryId() ?>">
            <label for="categoryName">category Name:</label>
            <input type="text" name="categoryName" id="categoryName" maxlength="150" required autofocus
            value="<?= $category->getCategoryId() ?> ">
        </div>

        <div class="form-row">
            <button class="addProduct" type="submit" name="submitUpdateCategory">update Categories</button>
        </div>

    </fieldset>
</form>