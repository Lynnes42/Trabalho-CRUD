<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit();
} else {
    session_unset();
    session_destroy();

    header('Location: ../index.html');
    exit;
}






