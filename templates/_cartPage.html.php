<?php

// Include references (form helper functions)
require_once ROOT_DIR . "includes/form.php";

?>
<h2 class="product-name">Shopping cart</h2>


<?php include "_formErrorSummary.html.php" ?>

<?php if ($cart->count() === 0): ?>

    <p><a class="link-blue" href="index.php">Continue Shopping!</a></p>

    <!-- password hasher -->
    <!-- <?php
    echo hash('sha256', 'password2');
    ?> -->

<?php else: ?>



    <table class="shoppingcart">
        <tr>
            <th>Photo</th>
            <th>Item</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Action</th>
        </tr>
        <?php foreach ($cart->getItems() as $item): ?>

            <?php
            $itemName = $item->getItemName();
            $imageFilename = $item->getPhoto();
            ?>
            <tr>
                <td><img class="product-card__photocart" src="./photos/<?= $imageFilename ?>" alt="<?= $itemName ?>"></td>

                <td>
                    <?= $itemName ?>
                </td>
                <td>
                    <?= sprintf('$%1.2f', $item->getPrice()) ?>
                </td>

                <td>
                    <?= $item->getQuantity() ?>
                </td>
                <th>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="itemId" value="<?= $item->getItemId() ?>">
                        <button type="submit" name="submitRemoveFromCart">Remove</button>
                    </form>
                </th>
            </tr>
        <?php endforeach ?>
    </table>

    <p><strong>Cart total:
            <?= sprintf('$%1.2f', $cart->calculateTotal()) ?>
        </strong></p>

    <div class="checkout"><a href="checkout.php"><button>checkout</button></a></div>


<?php endif ?>