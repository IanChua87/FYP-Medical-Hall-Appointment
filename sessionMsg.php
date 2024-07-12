<?php 
if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
    echo "<div class='session-msg-success' id='session-msg-success'>" 
    . "<p class='text-center'>"
    . $_SESSION['message'] 
    . "<p>"
    . "</div>";
    unset($_SESSION['message']);
}

if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
    echo "<div class='session-msg-error' id='session-msg-error'>" 
    . "<p class='text-center'>"
    . $_SESSION['error'] 
    . "<p>"
    . "</div>";
    unset($_SESSION['error']);
}
