<?php
require_once 'config.php';

$error = '';
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($phone) || empty($password)) {
        $error = 'Введите номер телефона и пароль.';
    } else {
        if (loginUser($pdo, $phone, $password)) {
            header('Location: ' . $redirect);
            exit();
        } else {
            $error = 'Неверный номер телефона или пароль.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход для читателей - ДТК Центр чтения</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">ДТК Центр чтения</a>
        </div>
    </nav>

    <main class="container flex-grow-1 d-flex align-items-center justify-content-center" style="max-width: 500px;">
        <div class="card shadow w-100">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Вход в личный кабинет</h2>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="+7XXXXXXXXXX" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="register.php">Нет аккаунта? Зарегистрироваться</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p>
        </div>
    </footer>

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>