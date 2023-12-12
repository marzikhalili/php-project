<?php

    // Include references (form helper functions)
    require_once ROOT_DIR . "includes/form.php";

    // Build category object
    $category = new Category();

?><h2 style="display: flex; justify-content: center; align-itens: center; margin:10px; font-weight:bold; color:#00aced">Manage categories</h2>

<?php include "_formErrorSummary.html.php" ?>

<p>
    <a class="link-blue" href="manageCategories.php?action=add">➕ Add new product</a>
</p>

<?php if ($category->getNumberOfCategories() === 0): ?>

<p>No categories to display, please add one.</p>

<?php else: ?>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th></th>
    </tr>
    <?php foreach ($category->getCategories() as $item): ?>
    <tr>
        <td><?= $item["categoryId"] ?></td>
        <td><?= $item["categoryName"] ?></td>
        <th>
            <!-- <a href="manageCategories.php?action=edit&id=xxx">Edit</a> -->
            <form action="manageCategories.php" method="get">
                <input type="hidden" name="categoryId" value="<?= $item["categoryId"] ?>">
                <button type="submit" name="action" value="edit">Edit</button>
                <button type="submit" name="action" value="delete">Delete</button>
            </form>
        </th>
    </tr>
    <?php endforeach ?>
</table>

<p><strong>Total categories: <?= $category->getNumberOfCategories() ?></strong></p>

<?php endif ?>