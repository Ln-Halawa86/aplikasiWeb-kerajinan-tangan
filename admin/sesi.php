<?php 
include "../config/koneksi.php";
session_start();
if(!isset($_SESSION['login'])) {
    return header("Location: index.php");
}
?>