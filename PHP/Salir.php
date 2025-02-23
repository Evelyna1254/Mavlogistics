<?php 
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../Html/iniciosesion.php");
    exit();
?>
