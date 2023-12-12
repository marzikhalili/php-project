<?php

// Include references (form helper functions)
require_once ROOT_DIR . "includes/form.php";

?><h2 class="subhead">Add a new category</h2>

<p class="messagebox">Please fill out the form to add a new category.</p>

<?php include "_formErrorSummary.html.php" ?>

<form action="manageCategories.php" method="post" enctype="multipart/form-data" novalidate>
    <fieldset>
        <legend>Add category</legend>

        <div class="form-row">
            <label for="categoryName">category Name:</label>
            <input type="text" name="categoryName" id="categoryName" maxlength="150" required autofocus <?= setValue("categoryName") ?>>
        </div>

        <div class="form-row">
            <button class="addProduct" type="submit" name="submitAddCategory">Add Categories</button>
        </div>

    </fieldset>
</form>