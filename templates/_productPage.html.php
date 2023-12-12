<?php if (empty($items)): ?>

    <p>No products.</p>

<?php else: ?>

    <ul class="product-list">

        <?php foreach ($items as $item): ?>

            <?php
            // Extract person's data
            $itemName = $item["itemName"];
            $price = $item["price"];
            $salePrice = $item["salePrice"];
            $imageFilename = $item["photo"];

            ?>



            <h1 class="product-name">
                <?= $itemName ?>
            </h1>

            <div class="product-container">
                <div class="product-image">
                    <img class="product-card__photo" src="./photos/<?= $imageFilename ?>" alt="<?= $itemName ?>" />
                </div>
                <div class="product-info">
                    <h2 class="subhead">Description</h2>
                    <p class="des">
                        <?= $item["description"] ?>
                    </p>
                    <h2 class="subhead"> Price</h2>
                    <div class="prices">
                        <?php if ($salePrice == 0 || $salePrice === NULL): ?>
                            <!-- if not on sale -->
                            <span class="product-card-price">
                                <?= sprintf('$%1.2f', $item["price"]) ?? null ?>
                            </span>
                        <?php else: ?>
                            <!-- otherwise, is on sale -->
                            <div class="wrp">
                                <span class="product-card__promo-price">
                                    <?= sprintf('$%1.2f', $salePrice) ?? null ?>
                                    <span class="product-card__old-price-was">was</span>
                                    <del class="product-card__old-price">
                                        <?= sprintf('$%1.2f', $item["price"]) ?>
                                    </del>
                            </div>

                        <?php endif; ?>

                        <form class="addtocart" action="cart.php" method="post">
                            <input type="hidden" name="itemId" value="<?= $item["itemId"] ?>">
                            <input type="number" name="quantity" min="1" value="1" aria-label="quantity" title="quantity">
                            <button type="submit" name="submitAddToCart">Add to cart</button>
                        </form>
                    </div>
                </div>


            </div>

        <?php endforeach ?>

    </ul>

<?php endif ?>