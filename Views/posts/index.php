<?php
    if(isset($_SESSION['statement'])){
        $statement = $_SESSION['statement'];
        unset($_SESSION['statement']);
    }
?>

<div class="post-data" >
    <div class="title"><h2><?= $statement['title'] ?></h2></div>
    <div class="content"><?= $statement['content'] ?></div>
    <div class="author">Author:<i> <?= $statement['username'] ?></i></div>
    <div class="date">Date created: <i><?= $statement['date_created']?></i> </div>
</div>
