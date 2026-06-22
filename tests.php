<?php
require_once 'config.php';

if (!isUserLoggedIn()) {
    header('Location: user_login.php?redirect=tests.php');
    exit();
}

$tests = $pdo->query("SELECT * FROM tests ORDER BY sort_order ASC, created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тесты - ДТК Центр чтения</title>
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
                    <li class="nav-item"><a class="nav-link" href="tests.php">Тесты</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout_user.php">Выйти (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a></li>
                    <?php if (isStaff()): ?>
                        <li class="nav-item"><a class="nav-link" href="admin/index.php">Управление</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Выйти (админ)</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Админ вход</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="row g-4">
            <?php if (empty($tests)): ?>
                <div class="col-12">
                    <div class="alert alert-info">Нет тестов</div>
                </div>
            <?php else: ?>
                <?php $index = 1; foreach ($tests as $test): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 text-center shadow-sm test-card">
                            <div class="card-body d-flex flex-column">
                                <div class="test-icon mb-3">
                                    <?php if (!empty($test['image_path'])): ?>
                                        <img src="<?= htmlspecialchars($test['image_path']) ?>" alt="Фото писателя" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                    <?php else: ?>
                                        <img src="images/image<?= $index ?>.png" alt="Писатель" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                                    <?php endif; ?>
                                </div>
                                <h5 class="card-title"><?= htmlspecialchars($test['title']) ?></h5>
                                <p class="card-text small text-secondary"><?= nl2br(htmlspecialchars(mb_substr($test['description'], 0, 120))) ?></p>
                                <a href="test.php?id=<?= $test['id'] ?>" class="btn btn-primary mt-auto stretched-link">Пройти тест</a>
                            </div>
                        </div>
                    </div>
                <?php $index++; endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p>
        </div>
    </footer>

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>