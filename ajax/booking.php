<?php
session_start();
require_once "../models/Home.php";
$model = new Home;
$_SESSION['booking'] = $_POST;
?>
