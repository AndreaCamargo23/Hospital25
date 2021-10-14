<?php 
    session_start();
    unset($_SESSION['session']);
    unset($_SESSION['rol']);
    unset($_SESSION['']);
    unset($_SESSION['user']);
    session_destroy(); 
    header('Location: ../login.php'); 
?>