<?php $this->title = "Create Post";

$fillTitle = false;
$fillContent = false;
if(key_exists("post-query",$_SESSION)){
    $data =$_SESSION['post-query'];
    if(key_exists(FORM_POST_TITLE,$data)){
        $fillTitle = $data[FORM_POST_TITLE];
    }
    if(key_exists(FORM_POST_CONTENT,$data)){
        $fillContent = $data[FORM_POST_CONTENT];
    }
    unset($_SESSION['post-query']);
}
?>

<form class="create-post" method="post" xmlns="http://www.w3.org/1999/html">
    <div><label for="<?=FORM_POST_TITLE?>"><input type="text" name="<?=FORM_POST_TITLE?>" id="<?=FORM_POST_TITLE?>" <?php if($fillTitle) : ?> value="<?= $fillTitle; endif ?> "></label></div>
    <div><label for="<?=FORM_POST_CONTENT?>"><textarea
                name="<?=FORM_POST_CONTENT?>"
                id="<?=FORM_POST_CONTENT?>"></textarea>
        </label>
    </div>
    <div><input type="submit"></div>
