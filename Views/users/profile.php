<?php
$statement = $_SESSION['statement']->get_result()->fetch_assoc();
unset($_SESSION['statement']);
?>

<h1><?=$statement['username']?>'s profile</h1>

<div class="first-name">First Name: <?= $statement['first_name'] ?></div>
<div class="first-name">Last Name: <?= $statement['last_name'] ?></div>
<div class="first-name">Email: <?= $statement['email'] ?></div>
<div class="first-name">Date registered: <?= $statement['date_registered'] ?></div>