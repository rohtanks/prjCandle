<?php
if(!isset($_SESSION)){
     session_start();
}
include '../config.php';
include '../common.php';
include '../dbConfig.php';

$kind= $_POST['kind'];



?>
