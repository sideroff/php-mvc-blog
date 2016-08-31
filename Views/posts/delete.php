
<div><h2><label for="title">Title:</label></h2></div>
<input type="text" disabled="disabled" class="title"  id="title" value="<?php echo $_SESSION['post']['title']?>">
<div><h2><label for="content">Content:</label></h2></div>
<div><textarea  disabled="disabled" id="content" cols="45" rows="5"><?php echo $_SESSION['post']['content']?></textarea></div>
<form class="edit-post"  method="post">
    <input type="text" hidden="hidden" value="<?php echo $_SESSION['post']['post_id']?>">
    <span>Are you sure you want to <strong>DELETE</strong> this post? </span> <input type="submit" value="DELETE!">
</form>

<?php
unset($_SESSION['post']);
?>