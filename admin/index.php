<?php
require_once '../config.php';
if (!isStaff()) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    foreach ($_POST['sort_order'] as $id => $order) {
        $id = (int)$id;
        $order = (int)$order;
        $pdo->prepare("UPDATE tests SET sort_order = ? WHERE id = ?")->execute([$order, $id]);
    }
    header("Location: index.php?msg=updated");
    exit();
}

$tests = $pdo->query("SELECT * FROM tests ORDER BY sort_order ASC, created_at DESC")->fetchAll();
$message = isset($_GET['msg']) && $_GET['msg'] == 'updated' ? "Порядок обновлён" : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление - ДТК Центр чтения</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-dark bg-primary navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="../index.php">ДТК Центр</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="writer.php">Писатель</a></li>
                    <li class="nav-item"><a class="nav-link" href="results.php">Результаты</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Выйти</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Тесты</h2>
            <a href="edit_test.php" class="btn btn-success">Создать тест</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <form method="post">
                    <input type="hidden" name="update_order" value="1">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th style="width: 60px">ID</th><th>Название</th><th style="width: 120px">Порядок</th><th style="width: 150px">Действия</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tests as $test): ?>
                                <tr>
                                    <td><?= $test['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($test['title']) ?></strong><br><small class="text-secondary"><?= htmlspecialchars(mb_substr($test['description'], 0, 60)) ?></small></td>
                                    <td><input type="number" name="sort_order[<?= $test['id'] ?>]" value="<?= $test['sort_order'] ?>" class="form-control form-control-sm" style="width: 80px;"></td>
                                    <td><a href="edit_test.php?id=<?= $test['id'] ?>" class="btn btn-sm btn-outline-primary">Ред.</a> <a href="delete_test.php?id=<?= $test['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить тест?')">Уд.</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 text-end border-top">
                        <button type="submit" class="btn btn-primary">Сохранить порядок</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p>
        </div>
    </footer>

    <script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>