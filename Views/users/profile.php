<?php
$statement = $_SESSION['statement'];
unset($_SESSION['statement']);
?>

<h1><?=$statement['username']?>'s profile</h1>

<div class="avatar_wrapper">Avatar: <img class="avatar" src="<?= AVATARS_PATH . $statement['id'] . ".png" ?>" alt="avatar or default image" onerror="this.onerror=null;this.src= '<?= AVATARS_DEFAULT?>';"</div>

<?php if($_SESSION && key_exists('username',$_SESSION) && $statement['username'] == $_SESSION['username']) : ?>

<div><button class="show-change-avatar-form">Change avatar</button></div>
<?php //enctype is crucial here ?>
<form class="change-avatar-form" enctype="multipart/form-data" method="post" hidden="hidden">
    <div><label for="avatar">Allowed files - .png</label>
        <div><label for="avatar">New avatar </label></div><input type="file" id="avatar" name="avatar"></div>
        <input type="submit" value="Save changes!">
</form>
<?php endif; ?>

<div class="profile-data" >
    <div class="first-name">First Name: <?= $statement['first_name'] ?></div>
    <div class="last-name">Last Name: <?= $statement['last_name'] ?></div>
    <div class="email">Email: <?= $statement['email'] ?></div>
    <div class="date-registered">Date registered: <?= $statement['date_registered'] ?></div>
</div>
