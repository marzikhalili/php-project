<?php

// Include references (form helper functions)
require_once ROOT_DIR . "includes/form.php";

?><h2>Delete a category</h2>
<p>Are you sure you want to delete the <strong>'<?= $product->getProductName() ?? "NONE" ?>'</strong> product?</p>

<?php include "_formErrorSummary.html.php" ?>

<form action="manageProducts.php" method="post" novalidate>
    <input type="hidden" name="itemId" value="<?= $product->getItemId() ?? 0 ?>">
    <div class="form-row">
        <button type="submit" name="submitDeleteProduct">Delete Product</button>
        <button type="submit" name="">Cancel</button>
    </div>
</form>