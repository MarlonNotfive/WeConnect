<?php
    require_once 'googleAuth/vendor/autoload.php';
    session_start();

    session_unset();

    session_destroy();

    header("Location: ../index.php");
    exit();
?>
