<?php
if(isset($_SESSION['user'])){
    header('location:voluntary.php');die;
}