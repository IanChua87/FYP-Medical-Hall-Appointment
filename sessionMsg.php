<?php 
if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
    echo "<div class='session-msg-success text-center' id='session-msg-success'>" 
    . $_SESSION['message'] 
    . "</div>";
    unset($_SESSION['message']);
}

if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
    echo "<div class='session-msg-error text-center' id='session-msg-error'>" 
    . $_SESSION['error'] 
    . "</div>";
    unset($_SESSION['error']);
}
