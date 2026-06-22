<?php
require_once '../config.php';
if (!isStaff()) {
    header('Location: ../login.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $pdo->prepare("DELETE FROM tests WHERE id = ?")->execute([$id]);
}
header('Location: index.php');
exit();