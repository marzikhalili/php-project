<h2>Create new user</h2>




<?php include "_error.html.php" ?>
<?php include "_success.html.php" ?>

<form action="createUser.php" method="post" novalidate>
    <fieldset>
        <div class="form-row">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= setValue("username") ?>" required>
        </div>

        <div class="form-row">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?= setValue("password") ?>" required>
        </div>

        <div class="form-row">
            <button class="anybtn" type="submit" name="submitCreateUser">Create new user</button>
        </div>
    </fieldset>
</form>