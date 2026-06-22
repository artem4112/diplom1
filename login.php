<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($login === 'dtk' && $password === 'dtk') {
        $_SESSION['staff_logged_in'] = true;
        header('Location: admin/index.php');
        exit();
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход для сотрудников - ДТК Центр чтения</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/logo.png" alt="Логотип" width="225" height="150">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                    <?php if (isStaff()): ?>
                    <li class="nav-item"><a class="nav-link" href="admin/index.php">Управление</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link active" href="login.php">Вход</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container flex-grow-1 d-flex align-items-center justify-content-center" style="max-width: 500px;">
        <div class="card shadow w-100">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Авторизация</h2>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="login" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                </form>
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