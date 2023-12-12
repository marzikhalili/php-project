<?php foreach ($items as $item): ?>

<?php
// Extract items data
$itemName = $item["itemName"];
$price = $item["price"];
$salePrice = $item["salePrice"];
$imageFilename = $item["photo"];

?>
<a class="product-card" href="product.php?id=<?= $item["itemId"] ?>">
    <span class="product-card__top">
        <img class="product-card__photo" src="./photos/<?=$imageFilename?>" width="148" height="148"
            alt="soccer-ball Photo" />
    </span>
    <div class="product-card__bottom">
        <div class="prices">
            <?php if ($salePrice == 0 || $salePrice == NULL ): ?>
            <!-- if not on sale -->
            <span class="product-card-price"><?= sprintf('$%1.2f', $item["price"]) ?? null ?></span>
            <?php else: ?>
            <!-- otherwise, is on sale -->
            <div class="wrp">
                <span class="product-card__promo-price"><?= sprintf('$%1.2f', $salePrice) ?? null ?></span>
                <span class="product-card__old-price-was">was</span>
                <del class="product-card__old-price"><?= sprintf('$%1.2f', $item["price"]) ?></del>
            </div>
            <?php endif; ?>
        </div>
        <span class="product-card__name">
            <?= $item["itemName"] ?>
        </span>
    </div>
</a>

<?php endforeach ?>