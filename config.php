<?php
session_start();

$host = 'localhost';
$dbname = 'dtk_center';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

function isStaff() {
    return isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true;
}

function getTest($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM tests WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getQuestions($pdo, $test_id) {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE test_id = ? ORDER BY id");
    $stmt->execute([$test_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getWriterOfMonth($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM writer_of_month WHERE id = 1");
    $stmt->execute();
    $writer = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare("SELECT * FROM books WHERE writer_id = 1 ORDER BY sort_order");
    $stmt->execute();
    $writer['books_list'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $writer;
}

function updateWriterOfMonth($pdo, $name, $description, $image_path = null) {
    if ($image_path) {
        $stmt = $pdo->prepare("UPDATE writer_of_month SET name = ?, description = ?, image_path = ? WHERE id = 1");
        return $stmt->execute([$name, $description, $image_path]);
    } else {
        $stmt = $pdo->prepare("UPDATE writer_of_month SET name = ?, description = ? WHERE id = 1");
        return $stmt->execute([$name, $description]);
    }
}

function getBooks($pdo, $writer_id = 1) {
    $stmt = $pdo->prepare("SELECT * FROM books WHERE writer_id = ? ORDER BY sort_order");
    $stmt->execute([$writer_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addBook($pdo, $writer_id, $title, $year, $genre, $language, $description, $sort_order = 0) {
    $stmt = $pdo->prepare("INSERT INTO books (writer_id, title, year, genre, language, description, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$writer_id, $title, $year, $genre, $language, $description, $sort_order]);
}

function updateBook($pdo, $id, $title, $year, $genre, $language, $description, $sort_order) {
    $stmt = $pdo->prepare("UPDATE books SET title = ?, year = ?, genre = ?, language = ?, description = ?, sort_order = ? WHERE id = ?");
    return $stmt->execute([$title, $year, $genre, $language, $description, $sort_order, $id]);
}

function deleteBook($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
    return $stmt->execute([$id]);
}

function saveTestResult($pdo, $test_id, $user_name, $user_email, $score, $total, $percentage, $user_id = null) {
    if ($user_id === null && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }
    $stmt = $pdo->prepare("INSERT INTO test_results (test_id, user_name, user_email, score, total, percentage, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$test_id, $user_name, $user_email, $score, $total, $percentage, $user_id]);
}

function getTestResults($pdo, $test_id = null, $limit = null) {
    $sql = "SELECT tr.*, t.title as test_title FROM test_results tr LEFT JOIN tests t ON tr.test_id = t.id";
    $params = [];
    if ($test_id) {
        $sql .= " WHERE tr.test_id = ?";
        $params[] = $test_id;
    }
    $sql .= " ORDER BY tr.created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . (int)$limit;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isUserLoggedIn() {
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
}

function registerUser($pdo, $full_name, $phone, $password, $email = null) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, phone, email, password) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$full_name, $phone, $email, $hashed]);
}

function loginUser($pdo, $phone, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->execute([$phone]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_phone'] = $user['phone'];
        return true;
    }
    return false;
}

function getUserCompletedTestsCount($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT test_id) FROM test_results WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return (int)$stmt->fetchColumn();
}

function getUserById($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>