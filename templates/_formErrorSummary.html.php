<style>
    .error-summary {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        margin: 15px;
        border-radius: 10px;
        color: #000;
        background-color: #ff690c;
    }
</style>
<?php if (!empty($errors)): ?>
    <div class="error-summary">
        <p>please fix the following errors:</p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li>
                    <?= $error ?>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>