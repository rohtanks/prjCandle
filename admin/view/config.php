<?php
//사용할 DB 접속정보를 포함하는 config.php
header("Content-Type: text/html; charset=UTF-8");

$mysqli = new mysqli('localhost', 'root', 'autoset', 'prjcandle');
if (mysqli_connect_error()) {
    exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

$mysqli->set_charset('utf8');
?>