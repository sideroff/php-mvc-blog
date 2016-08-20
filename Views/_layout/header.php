<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?=APP_ROOT?>/content/styles.css" />
    <script src="<?=APP_ROOT?>/content/libs/jquery.min.js"></script>
    <script src="<?=APP_ROOT?>/content/scripts.js"></script>
</head>
<body>
    <header>
        <a href="<?=APP_ROOT?>"><img src="<?=APP_ROOT?>/content/images/site-logo.png"></a>
        <?php if(isset($_SESSION) && key_exists("username",$_SESSION)):
            var_dump($_SESSION);
                echo '<div class="greeting">Hello, ' .$_SESSION["username"] . '!</div>';
                echo '<a href="' . APP_ROOT . '/users/logout">Logout</a>"';
             else :
                 echo '<a href="' . APP_ROOT . '/users/login">Login!</a>';
                 echo '<a href="' . APP_ROOT . '/users/register">Register!</a>';
        endif ?>
    </header>
    <?php if(isset($_SESSION) && key_exists("messages",$_SESSION)):
        foreach ($_SESSION["messages"] as $msg) {
            echo '<div class="' . $msg["type"] . 'Message">' . $msg["text"] . '</div>';
            }
        unset($_SESSION["messages"]);
    endif ?>

<? require_once "show-messages.php"; ?>