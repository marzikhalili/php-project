<h2>Form Confirmed</h2>
<p>Thank you for submitting the form, we have recieved your message.</p>



<!--sesion start with id  -->
<!-- <?php if($_SESSION["id"]): ?>
    <p>haha</p>
<?php else: ?>
    <p>sad :(</p>
<?php endif ?> -->



<?php
    $_SESSION["cart"] = new ShoppingCart();

    $_SESSION["id"] = null;
?>

<script>
    // get the password from the user
    // $password = Getrs ;

    // $hashed_password = hash('sha256', $password);

    // hey database, does user Admin's password look like hashed_password?
    // yes: yaya
    // no: wrong password
</script>




<dl>
    <!-- <dt>First name</dt>
    <dd><?=$firstName ?? "" ?></dd>
    <dt>Last name</dt>
    <dd><?=$lastName ?? "" ?></dd>
    <dt>Email</dt>
    <dd><?=$email?? "" ?></dd> -->
</dl>