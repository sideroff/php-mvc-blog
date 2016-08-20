<?php
    if(key_exists("messages", $_SESSION) && count($_SESSION["messages"])>0){
        echo '<ul class="messages">';
        foreach ($_SESSION["messages"] as $msg) {
            echo '<li class="' . $msg['type'] . '">';
            echo htmlspecialchars($msg['text']);
            echo '</li>';
        }
        echo '</ul>';
        unset($_SESSION['messages']);
    }
?>