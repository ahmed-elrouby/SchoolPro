<?php
session_start();
include_once "app/middlewares/auth.php";
unset($_SESSION['user']);
header('location:login.php');