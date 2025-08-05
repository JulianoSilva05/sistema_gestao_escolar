<?php
// /config/verifica_login.php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../views/index.php");
    exit();
}
?>
