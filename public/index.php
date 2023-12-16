<?php
session_start();
include '../app/conf.php';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    include('../app/pages/chat.php'); 
} else {
    include('../app/pages/login.php');
}
?>
