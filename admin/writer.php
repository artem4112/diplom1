<?php
require_once '../config.php';
if (!isStaff()) {
    header('Location: ../login.php');
    exit();
}

$writer = getWriterOfMonth($pdo);
$books = $writer['books_list'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_writer'])) {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $image_path = $writer['image_path'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../images/';
            $tmp_name = $_FILES['image']['tmp_name'];
            $name_parts = pathinfo($_FILES['image']['name']);
            $extension = strtolower($name_parts['extension']);
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($extension, $allowed)) {
                $new_filename = 'writer_' . time() . '.' . $extension;
                $destination = $upload_dir . $new_filename;
                if (move_uploaded_file($tmp_name, $destination)) {
                    if ($writer['image_path'] != 'default.jpg' && file_exists($upload_dir . $writer['image_path'])) {
                        unlink($upload_dir . $writer['image_path']);
                    }
                    $image_path = $new_filename;
                } else {
                    $error = 'Ошибка загрузки файла';
                }
            } else {
                $error = 'Недопустимый формат файла';
            }
        }

        if (empty($error)) {
            if (updateWriterOfMonth($pdo, $name, $description, $image_path)) {
                $success = 'Данные писателя обновлены';
                $writer = getWriterOfMonth($pdo);
                $books = $writer['books_list'];
            } else {
                $error = 'Ошибка при сохранении данных писателя';
            }
        }
    }

    if (isset($_POST['add_book'])) {
        $title = $_POST['new_title'] ?? '';
        $year = $_POST['new_year'] ?? '';
        $genre = $_POST['new_genre'] ?? '';
        $language = $_POST['new_language'] ?? '';
        $description = $_POST['new_description'] ?? '';
        $sort_order = (int)($_POST['new_sort_order'] ?? 0);

        if (!empty($title)) {
            if (addBook($pdo, 1, $title, $year, $genre, $language, $description, $sort_order)) {
                $success = 'Книга добавлена';
                $writer = getWriterOfMonth($pdo);
                $books = $writer['books_list'];
            } else {
                $error = 'Ошибка при добавлении книги';
            }
        } else {
            $error = 'Название книги не может быть пустым';
        }
    }

    if (isset($_POST['edit_book'])) {
        $id = (int)($_POST['book_id'] ?? 0);
        $title = $_POST['edit_title'] ?? '';
        $year = $_POST['edit_year'] ?? '';
        $genre = $_POST['edit_genre'] ?? '';
        $language = $_POST['edit_language'] ?? '';
        $description = $_POST['edit_description'] ?? '';
        $sort_order = (int)($_POST['edit_sort_order'] ?? 0);

        if ($id > 0 && !empty($title)) {
            if (updateBook($pdo, $id, $title, $year, $genre, $language, $description, $sort_order)) {
                $success = 'Книга обновлена';
                $writer = getWriterOfMonth($pdo);
                $books = $writer['books_list'];
            } else {
                $error = 'Ошибка при обновлении книги';
            }
        } else {
            $error = 'Некорректные данные';
        }
    }
}

if (isset($_GET['delete_book'])) {
    $id = (int)$_GET['delete_book'];
    if ($id > 0) {
        deleteBook($pdo, $id);
        $writer = getWriterOfMonth($pdo);
        $books = $writer['books_list'];
        $success = 'Книга удалена';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование писателя месяца</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">← К списку</a>
            <span class="navbar-text">Писатель месяца</span>
            <a href="../logout.php" class="btn btn-outline-light btn-sm">Выйти</a>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
        <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

        <div class="card mb-4">
            <div class="card-header"><h3 class="h5 mb-0">Информация о писателе</h3></div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_writer" value="1">
                    <div class="mb-3"><label for="name" class="form-label">Имя писателя</label><input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($writer['name']) ?>" required></div>
                    <div class="mb-3"><label for="description" class="form-label">Описание</label><textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($writer['description']) ?></textarea></div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Изображение</label>
                        <div class="d-flex align-items-center gap-3"><img src="../images/<?= $writer['image_path'] ?>" alt="" style="width:80px; height:100px; object-fit:cover; border-radius:8px;"><input class="form-control" type="file" id="image" name="image" accept="image/*"></div>
                        <small class="text-secondary">Оставьте пустым, чтобы не менять изображение</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить данные писателя</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center"><h3 class="h5 mb-0">Книги</h3><button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#addBookForm">Добавить книгу</button></div>
            <div class="collapse" id="addBookForm">
                <div class="card-body border-bottom">
                    <form method="post">
                        <input type="hidden" name="add_book" value="1">
                        <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Название</label><input type="text" class="form-control" name="new_title" required></div><div class="col-md-6 mb-3"><label class="form-label">Год</label><input type="text" class="form-control" name="new_year"></div><div class="col-md-6 mb-3"><label class="form-label">Жанр</label><input type="text" class="form-control" name="new_genre"></div><div class="col-md-6 mb-3"><label class="form-label">Язык</label><input type="text" class="form-control" name="new_language"></div><div class="col-12 mb-3"><label class="form-label">Описание</label><textarea class="form-control" name="new_description" rows="3"></textarea></div><div class="col-12 mb-3"><label class="form-label">Порядок сортировки</label><input type="number" class="form-control" name="new_sort_order" value="0"></div></div>
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </form>
                </div>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($books as $book): ?>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div><strong><?= htmlspecialchars($book['title']) ?></strong> <?php if ($book['year']): ?> <span class="text-secondary">(<?= $book['year'] ?>)</span><?php endif; ?><br><small class="text-secondary">Жанр: <?= $book['genre'] ?: '—' ?>, Язык: <?= $book['language'] ?: '—' ?></small><?php if ($book['description']): ?><p class="small mt-1"><?= nl2br(htmlspecialchars($book['description'])) ?></p><?php endif; ?></div>
                        <div><button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#editBook<?= $book['id'] ?>">✎</button> <a href="?delete_book=<?= $book['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Удалить книгу?')">✕</a></div>
                    </div>
                    <div class="collapse mt-3" id="editBook<?= $book['id'] ?>">
                        <form method="post">
                            <input type="hidden" name="edit_book" value="1"><input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <div class="row"><div class="col-md-6 mb-3"><label class="form-label">Название</label><input type="text" class="form-control" name="edit_title" value="<?= htmlspecialchars($book['title']) ?>" required></div><div class="col-md-6 mb-3"><label class="form-label">Год</label><input type="text" class="form-control" name="edit_year" value="<?= htmlspecialchars($book['year']) ?>"></div><div class="col-md-6 mb-3"><label class="form-label">Жанр</label><input type="text" class="form-control" name="edit_genre" value="<?= htmlspecialchars($book['genre']) ?>"></div><div class="col-md-6 mb-3"><label class="form-label">Язык</label><input type="text" class="form-control" name="edit_language" value="<?= htmlspecialchars($book['language']) ?>"></div><div class="col-12 mb-3"><label class="form-label">Описание</label><textarea class="form-control" name="edit_description" rows="2"><?= htmlspecialchars($book['description']) ?></textarea></div><div class="col-12 mb-3"><label class="form-label">Порядок сортировки</label><input type="number" class="form-control" name="edit_sort_order" value="<?= $book['sort_order'] ?>"></div></div>
                            <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center"><p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p></div>
    </footer>

    <script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>