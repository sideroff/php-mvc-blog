
<div>
<div><h2><label for="content">Content:</label></h2></div>
<div><textarea  disabled="disabled" id="content" cols="45" rows="5"><?php echo $_SESSION['comment']['content']?></textarea></div>
<form class="delete-comment" method="post">
    <input type="text" hidden="hidden" value="<?php echo $_SESSION['comment']['id']?>">
    <span>Are you sure you want to <strong>DELETE</strong> this comment? </span> <input type="submit" value="DELETE!">
</form>

<?php
unset($_SESSION['comment']);
?>