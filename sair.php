<?php
session_start();
unset($_SESSION['id_cliente']);
header("location: index.php");
?>