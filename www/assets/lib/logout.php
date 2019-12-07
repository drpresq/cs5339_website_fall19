<?php // Logout.php
      // Wipes out the user's session
    session_start();
    require_once 'strut.php';
    $_SESSION['Authenticated'] = false;
    $_SESSION['SessionExp'] = time() - 1; //Set Expiration for 1 second ago
    $_SESSION['user_type'] = 'guest';

    header('location: http://'.$_SERVER['HTTP_HOST'].$urlStrut.'index.php')

?>