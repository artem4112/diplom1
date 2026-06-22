<?php
session_start();
unset($_SESSION['staff_logged_in']);
header('Location: index.php');
exit();