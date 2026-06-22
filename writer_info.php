<?php
require_once 'config.php';

if (!isUserLoggedIn()) {
    header('Location: user_login.php?redirect=writer_info.php');
    exit();
}

$writer = getWriterOfMonth($pdo);
$books = getBooks($pdo, 1);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Писатель месяца - ДТК Центр чтения</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="ДТК" width="30" height="30" class="d-inline-block align-text-top me-2">
                Писатель месяца
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="tests.php">Тесты</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="card shadow-lg border-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-md-4 text-center p-4 bg-light">
                    <img src="images/<?= htmlspecialchars($writer['image_path'] ?? 'default.jpg') ?>" alt="Писатель" class="img-fluid rounded-circle shadow" style="max-width: 200px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title" style="color: var(--deep-teal);"><?= htmlspecialchars($writer['name']) ?></h2>
                        <p class="card-text"><?= nl2br(htmlspecialchars($writer['description'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-white">
                <h3 class="h5 mb-0">Книги</h3>
            </div>
            <div class="list-group list-group-flush">
                <?php if (empty($books)): ?>
                    <div class="list-group-item text-secondary">Нет добавленных книг</div>
                <?php else: ?>
                    <?php foreach ($books as $book): ?>
                        <div class="list-group-item">
                            <h5 class="mb-1"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="mb-1 text-secondary">
                                <?php if ($book['year']): ?>Год: <?= htmlspecialchars($book['year']) ?><br><?php endif; ?>
                                <?php if ($book['genre']): ?>Жанр: <?= htmlspecialchars($book['genre']) ?><br><?php endif; ?>
                                <?php if ($book['language']): ?>Язык: <?= htmlspecialchars($book['language']) ?><?php endif; ?>
                            </p>
                            <?php if ($book['description']): ?>
                                <p class="mt-2 small"><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-outline-primary">← На главную</a>
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