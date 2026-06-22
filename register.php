<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($full_name) || empty($phone) || empty($password)) {
        $error = 'Заполните все обязательные поля (ФИО, телефон, пароль).';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают.';
    } elseif (strlen($password) < 4) {
        $error = 'Пароль должен быть не менее 4 символов.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
        $stmt->execute([$phone]);
        if ($stmt->fetch()) {
            $error = 'Пользователь с таким номером телефона уже зарегистрирован.';
        } else {
            if (registerUser($pdo, $full_name, $phone, $password, $email)) {
                $success = 'Регистрация успешна! Теперь вы можете войти.';
                $full_name = $phone = $email = '';
            } else {
                $error = 'Ошибка регистрации. Попробуйте позже.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - ДТК Центр чтения</title>
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
                <h2 class="h5 mb-0">Регистрация</h2>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">ФИО *</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= htmlspecialchars($full_name ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" placeholder="+7XXXXXXXXXX" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email (необязательно)</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль *</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Подтверждение пароля *</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="user_login.php">Уже есть аккаунт? Войти</a>
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