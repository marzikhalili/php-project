<?php

    // Include references (form helper functions)
    require_once ROOT_DIR . "includes/form.php";

?><h2>Delete a category</h2>

<p>Are you sure you want to delete the <strong>'<?= $category->getCategoryName() ?? "NONE" ?>'</strong> category?</p>

<?php include "_formErrorSummary.html.php" ?>

<form action="manageCategories.php" method="post" novalidate>
    <input type="hidden" name="categoryId" value="<?= $category->getCategoryId() ?? 0 ?>">
    <div class="form-row">
        <button type="submit" name="submitDeleteCategory">Delete category</button>
        <button type="submit" name="">Cancel</button>
    </div>
</form>