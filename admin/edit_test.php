<?php
require_once '../config.php';
if (!isStaff()) {
    header('Location: ../login.php');
    exit();
}

$test_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$test = null;
$questions = [];

if ($test_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM tests WHERE id = ?");
    $stmt->execute([$test_id]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($test) {
        $stmt = $pdo->prepare("SELECT * FROM questions WHERE test_id = ? ORDER BY id");
        $stmt->execute([$test_id]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_image'])) {
    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $file = $_FILES['test_image'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            $filename = 'test_' . $test_id . '_' . time() . '.' . $ext;
            $destination = $upload_dir . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $relative_path = 'uploads/' . $filename;
                $stmt = $pdo->prepare("UPDATE tests SET image_path = ? WHERE id = ?");
                $stmt->execute([$relative_path, $test_id]);
                header("Location: edit_test.php?id=$test_id&success=image");
                exit();
            } else {
                $image_error = 'Ошибка загрузки файла';
            }
        } else {
            $image_error = 'Недопустимый формат (только JPG, PNG, GIF)';
        }
    } else {
        $image_error = 'Ошибка при загрузке файла';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_test'])) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($test_id > 0) {
        $stmt = $pdo->prepare("UPDATE tests SET title = ?, description = ?, sort_order = ? WHERE id = ?");
        $stmt->execute([$title, $description, $sort_order, $test_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO tests (title, description, sort_order) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $sort_order]);
        $test_id = $pdo->lastInsertId();
        header("Location: edit_test.php?id=$test_id");
        exit();
    }

    if ($test_id > 0) {
        $pdo->prepare("DELETE FROM questions WHERE test_id = ?")->execute([$test_id]);

        $question_texts = $_POST['question_text'] ?? [];
        $option_a = $_POST['option_a'] ?? [];
        $option_b = $_POST['option_b'] ?? [];
        $option_c = $_POST['option_c'] ?? [];
        $correct = $_POST['correct'] ?? [];
        $hints = $_POST['hint'] ?? [];

        for ($i = 0; $i < count($question_texts); $i++) {
            if (empty($question_texts[$i])) continue;
            $stmt = $pdo->prepare("INSERT INTO questions (test_id, question_text, option_a, option_b, option_c, correct_option, hint) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $test_id,
                $question_texts[$i],
                $option_a[$i],
                $option_b[$i],
                $option_c[$i],
                $correct[$i],
                $hints[$i] ?? ''
            ]);
        }
    }

    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $test_id ? 'Редактирование' : 'Создание' ?> теста</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Назад</a>
            <span class="navbar-text"><?= $test_id ? 'Редактирование' : 'Создание' ?> теста</span>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Выйти</a>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <?php if (isset($_GET['success']) && $_GET['success'] == 'image'): ?>
            <div class="alert alert-success">Изображение загружено</div>
        <?php endif; ?>
        <?php if (isset($image_error)): ?>
            <div class="alert alert-danger"><?= $image_error ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="save_test" value="1">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название теста</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $test ? htmlspecialchars($test['title']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" id="description" name="description" rows="2"><?= $test ? htmlspecialchars($test['description']) : '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Порядок сортировки (чем меньше, тем выше)</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= $test ? $test['sort_order'] : '0' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Изображение писателя (для главной страницы)</label>
                        <?php if ($test && !empty($test['image_path'])): ?>
                            <div class="mb-2"><img src="../<?= htmlspecialchars($test['image_path']) ?>" style="max-width: 150px; border-radius: 8px;"></div>
                        <?php endif; ?>
                        <input type="file" class="form-control" name="test_image" accept="image/*">
                        <small class="text-secondary">Загрузите фото писателя (будет отображаться на главной странице). Рекомендуемый размер: 100x100 пикселей.</small>
                    </div>
                </div>
            </div>

            <h3 class="h5">Вопросы</h3>
            <div id="questions-container">
                <?php if ($questions): ?>
                    <?php foreach ($questions as $q): ?>
                    <div class="card mb-3 question-block">
                        <div class="card-body">
                            <button type="button" class="btn btn-sm btn-danger float-end remove-question">Удалить</button>
                            <div class="mb-3"><label class="form-label">Текст вопроса</label><input type="text" class="form-control" name="question_text[]" value="<?= htmlspecialchars($q['question_text']) ?>" required></div>
                            <div class="row">
                                <div class="col-md-4 mb-3"><label class="form-label">Вариант A</label><input type="text" class="form-control" name="option_a[]" value="<?= htmlspecialchars($q['option_a']) ?>" required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Вариант B</label><input type="text" class="form-control" name="option_b[]" value="<?= htmlspecialchars($q['option_b']) ?>" required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Вариант C</label><input type="text" class="form-control" name="option_c[]" value="<?= htmlspecialchars($q['option_c']) ?>" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="form-label">Правильный вариант</label><select class="form-select" name="correct[]"><option value="0" <?= $q['correct_option'] == 0 ? 'selected' : '' ?>>A</option><option value="1" <?= $q['correct_option'] == 1 ? 'selected' : '' ?>>B</option><option value="2" <?= $q['correct_option'] == 2 ? 'selected' : '' ?>>C</option></select></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Подсказка</label><input type="text" class="form-control" name="hint[]" value="<?= htmlspecialchars($q['hint'] ?? '') ?>"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card mb-3 question-block">
                        <div class="card-body">
                            <button type="button" class="btn btn-sm btn-danger float-end remove-question">Удалить</button>
                            <div class="mb-3"><label class="form-label">Текст вопроса</label><input type="text" class="form-control" name="question_text[]" required></div>
                            <div class="row"><div class="col-md-4 mb-3"><label class="form-label">Вариант A</label><input type="text" class="form-control" name="option_a[]" required></div><div class="col-md-4 mb-3"><label class="form-label">Вариант B</label><input type="text" class="form-control" name="option_b[]" required></div><div class="col-md-4 mb-3"><label class="form-label">Вариант C</label><input type="text" class="form-control" name="option_c[]" required></div></div>
                            <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Правильный вариант</label><select class="form-select" name="correct[]"><option value="0">A</option><option value="1">B</option><option value="2">C</option></select></div><div class="col-md-6 mb-3"><label class="form-label">Подсказка</label><input type="text" class="form-control" name="hint[]"></div></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3"><button type="button" class="btn btn-outline-primary" onclick="addQuestion()">Добавить вопрос</button></div>
            <div class="text-center"><button type="submit" class="btn btn-success btn-lg px-5">Сохранить тест</button></div>
        </form>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center"><p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p></div>
    </footer>

    <script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function addQuestion() {
        const container = document.getElementById('questions-container');
        const div = document.createElement('div');
        div.className = 'card mb-3 question-block';
        div.innerHTML = `<div class="card-body">
            <button type="button" class="btn btn-sm btn-danger float-end remove-question">Удалить</button>
            <div class="mb-3"><label class="form-label">Текст вопроса</label><input type="text" class="form-control" name="question_text[]" required></div>
            <div class="row"><div class="col-md-4 mb-3"><label class="form-label">Вариант A</label><input type="text" class="form-control" name="option_a[]" required></div><div class="col-md-4 mb-3"><label class="form-label">Вариант B</label><input type="text" class="form-control" name="option_b[]" required></div><div class="col-md-4 mb-3"><label class="form-label">Вариант C</label><input type="text" class="form-control" name="option_c[]" required></div></div>
            <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Правильный вариант</label><select class="form-select" name="correct[]"><option value="0">A</option><option value="1">B</option><option value="2">C</option></select></div><div class="col-md-6 mb-3"><label class="form-label">Подсказка</label><input type="text" class="form-control" name="hint[]"></div></div>
        </div>`;
        container.appendChild(div);
    }
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-question')) {
            e.target.closest('.question-block').remove();
        }
    });
    </script>
</body>
</html>