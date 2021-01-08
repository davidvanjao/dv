<?php
session_start();

unset($_SESSION['logado']);
unset($_SESSION['h_login']);
header("Location: index.php");
exit;