<?php

//include reference (form helmer functions)
require_once ROOT_DIR . "includes/form.php";
?>


<?php include "_formErrorSummary.html.php" ?>
<section class="content">
    <h1>Contact Us</h1>
    <p>We sell sports equipment online!</p>

    <form action="contactUs.php" method="post">
        <label for="name">First Name:<span class="star">*</span></label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="name">Last Name:<span class="star">*</span></label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="contactNumber">Contact number:<span class="star">*</span></label>
        <input type="text" name="contactNumber" id="contactNumber">

        <label for="email">Email:<span class="star">*</span></label>
        <input type="email" id="email" name="email" required>

        <label for="message">Question:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit" name="submit">Submit</button>
    </form>
</section>