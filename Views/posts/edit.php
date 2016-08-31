<form class="edit-post"  method="post">

    <div><h2><label for="title">Title:</label></h2></div>
    <input type="text" class="title" name="title" id="title" value="<?php echo $_SESSION['post']['title']?>">
    <div><h2><label for="content">Content:</label></h2></div>
    <div><textarea name="content" id="content" cols="45" rows="5"><?php echo $_SESSION['post']['content']?></textarea></div>
    <input type="submit" value="Save changes!">
</form>