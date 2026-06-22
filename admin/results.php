<?php
require_once '../config.php';
if (!isStaff()) {
    header('Location: ../login.php');
    exit();
}

$test_id = isset($_GET['test_id']) ? (int)$_GET['test_id'] : null;
$results = getTestResults($pdo, $test_id);
$tests = $pdo->query("SELECT id, title FROM tests ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты тестов</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Назад</a>
            <span class="navbar-text">Результаты тестов</span>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Выйти</a>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Список результатов</h3>
                <form method="get" class="d-flex">
                    <select name="test_id" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                        <option value="">Все тесты</option>
                        <?php foreach ($tests as $t): ?>
                            <option value="<?= $t['id'] ?>" <?= ($test_id == $t['id']) ? 'selected' : '' ?>><?= htmlspecialchars($t['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($test_id): ?>
                        <a href="results.php" class="btn btn-sm btn-outline-secondary">Сбросить</a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light"><tr><th>ID</th><th>Тест</th><th>ФИО</th><th>Email</th><th>Результат</th><th>Процент</th><th>Дата</th></tr></thead>
                    <tbody>
                        <?php if (empty($results)): ?>
                            <tr><td colspan="7" class="text-center">Нет результатов</td></tr>
                        <?php else: ?>
                            <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['test_title']) ?></td>
                                <td><?= htmlspecialchars($row['user_name']) ?></td>
                                <td><?= htmlspecialchars($row['user_email']) ?></td>
                                <td><?= $row['score'] ?>/<?= $row['total'] ?></td>
                                <td><?= $row['percentage'] ?>%</td>
                                <td><?= date('d.m.Y H:i', strtotime($row['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center"><p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p></div>
    </footer>
</body>
</html>