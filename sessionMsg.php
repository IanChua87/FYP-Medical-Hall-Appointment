<?php 
    if(isset($_SESSION['message'])){
        echo "<div class='session-msg text-center' id='session-msg'>" 
        . $_SESSION['message'] 
        . "</div>";
    } 
    unset($_SESSION['message']);
