<!-- Using htmlspecialchars() to safely encode the output for HTML... all "dangerous" chars are turned into entities, e.g. &gt; -->
<h2>You searched for: '<?= htmlspecialchars($search ?? "") ?>'</h2>
<?php include "_viewproductPage.html.php" ?>