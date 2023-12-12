<?php

//include reference (form helmer functions)
require_once ROOT_DIR . "includes/form.php";
?>

<?php include "_formErrorSummary.html.php" ?>

<!-- TODO: turn the nonvalidate off for the production time  -->
<form class="contact" action="checkout.php" method="post">
    <fieldset>
        <legend class="legend-name">Check Out</legend>
        <div class="form-row">
            <label for="firstName">First name:</label>
            <input type="text" name="firstName" id="firstName" required autofocus <?= setValue("firstName")?>>
        </div>
        <div class="form-row">
            <label for="lastName">Last name:</label>
            <input type="text" name="lastName" id="lastName" required <?= setValue("lastName")?>>
        </div>
        <div class="form-row">
            <label for="deliveryAddress">deliveryAddress:</label>
            <input type="tel" name="deliveryAddress" id="deliveryAddress" required <?= setValue("deliveryAddress")?>>
        </div>
        <div class="form-row">
            <label for="contactNumber">contactNumber:</label>
            <input type="tel" name="contactNumber" id="contactNumber" required <?= setValue("contactNumber")?>>
        </div>
        <div class="form-row">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required <?= setValue("email")?>>
        </div>
        <div class="form-row">
            <label for="Payment">Payment Option:</label>
            <select name="course" id="course">
                <option value="visa" <?= setSelected("Payment", "visa") ?>>Visa</option>
                <option value="mastercard" <?= setSelected("Payment", "mastercard") ?>>Mastercard web</option>
            </select>
        </div>
        <div class="form-row">
            <label for="creditCardNumber">Credit Card Number:</label>
            <input type="string" name="creditCardNumber" id="creditCardNumber" required
                <?= setValue("creditCardNumber")?>>
        </div>
        <div class="form-row">
            <label for="expiryDate">ExpiryDate:</label>
            <input type="string" name="expiryDate" id="expiryDate" required <?= setValue("expiryDate")?>>
        </div>
        <div class="form-row">
            <label for="NameOnCC">Name On Credit Card:</label>
            <input type="tel" name="NameOnCC" id="NameOnCC" required <?= setValue("NameOnCC")?>>
        </div>

        <div class="form-row">
            <button class="submitbt" type="submit" name="submitcheckout">Submit</button>
        </div>
    </fieldset>
</form>