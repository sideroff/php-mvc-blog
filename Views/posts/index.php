<?php
    if(isset($_SESSION['statement']['post'])){
        $statement = $_SESSION['statement']['post'];
        unset($_SESSION['statement']['post']);
    }
    if(isset($_SESSION['statement']['comments'])){
        $comments = $_SESSION['statement']['comments'];
        unset($_SESSION['statement']['comments']);
}
?>

<div class="post-data" >
    <div class="title"><h1><?= $statement['title'] ?></h1></div>
    <div class="content"><?= $statement['content'] ?></div>
    <div class="author">Author:<i> <?= $statement['username'] ?></i></div>
    <div class="date">Date created: <i><?= $statement['date_created']?></i> </div>
    <?php if($_SESSION && key_exists('username',$_SESSION) && $statement['username'] == $_SESSION['username']) : ?>
        <a href="<?php echo APP_ROOT.'/posts/edit/'.$statement['post_id']?>" class="edit-post" id="<?php echo $statement['post_id']?>">Edit!</a>
        <a href="<?php echo APP_ROOT.'/posts/delete/'.$statement['post_id']?>" class="edit-post" id="<?php echo $statement['post_id']?>">Delete!</a>

    <?php endif; ?>
</div>


<?php if($_SESSION && key_exists('username',$_SESSION)) : ?>

    <hr>
    <form class="write-comment-form"  method="post">
        <div><label for="content"><h2>Write comment:</h2></label></div>
        <div><textarea name="content" id="content" cols="45" rows="5"></textarea></div>
        <input type="submit" value="Comment!">
    </form>
<?php endif; ?>

<div class="comment-section"></div>
<?php
    if(isset($comments) && count($comments)>0) {
        echo '<hr>';
        echo '<h2>Comments:</h2>';
        echo '<div class="individual-comments-wrapper">';


         foreach($comments as $comment) : ?>
             
            <div class="individual-comment">
                <?=$comment['content']?>
                <div>Posted on: <i><?=$comment['date']?></i></div>
                <div>From: <a href="<?= APP_ROOT. "/users/profile/". $comment['author_id']?>"> <?=$comment['username']?></a></div>
                <div>
                    <button class="upvote" id="<?php echo $comment['comment_id']?>" onclick='vote(true,<?php echo $comment['comment_id']?>,<?php echo $_SESSION['userId']?>,"<?php echo VOTECONTROLLER_URL ?>")'>^</button>
                    <span class="upvotes" id="<?php echo $comment['comment_id']?>"><?=count($comment['upvotes'])?></span>
                </div>
                <div>
                    <button class="downvote" id="<?php echo $comment['comment_id']?>" onclick='vote(false,<?php echo $comment['comment_id']?>,<?php echo $_SESSION['userId']?>,"<?php echo VOTECONTROLLER_URL ?>")'>v</button>
                    <span class="downvotes" id="<?php echo $comment['comment_id']?>"><?=count($comment['downvotes'])?></span>
                </div>
                <?php
                if($comment['username'] == $_SESSION['username']) : ?>
                    <div>
                        <a href="<?php echo APP_ROOT.'/comments/delete/'.$comment['comment_id']?>" class="edit-post" id="<?php echo $statement['post_id']?>">Delete comment!</a>
                    </div>
                <?php endif ?>

            </div>
        <?php endforeach; echo '</div>'; }?>











