<h2 class="UPass" style="display: flex; justify-content: center; align-itens: center; margin:10px; font-weight:bold; color:#00aced">Update Password</h2>

<?php include "_error.html.php" ?>
<?php include "_success.html.php" ?>

<form action="manageUser.php" method="post" novalidate>
    <fieldset>
        <form action="changePassword.php" method="post">
            <div class="form-row">
                <label for="username">user Name</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-row">
                <label for="currentPassword">Current Password</label>
                <input type="password" name="currentPassword" id="currentPassword" required>
            </div>

            <div class="form-row">
                <label for="newPassword">New Password</label>
                <input type="password" name="newPassword" id="newPassword" required>
            </div>

            <div class="form-row">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required>
            </div>

            <div class="form-row">
                <button type="submit" name="submitManageUser">Submit</button>
                <button type="cancel" name="cancel" onclick="goBack()">Cancel</button>
                <!-- <a href="adminTab.php">Cancel</a> -->
            </div>
        </form>
    </fieldset>
</form>