<?php
require_once 'config.php';

if (!isUserLoggedIn()) {
    header('Location: user_login.php?redirect=result.php');
    exit();
}

if (!isset($_SESSION['test_results'])) {
    header('Location: index.php');
    exit();
}

$results = $_SESSION['test_results'];
$score = $results['score'];
$total = $results['total'];
$percentage = $results['percentage'];

if ($percentage >= 90) {
    $grade = 'Отлично';
    $grade_desc = 'Отличное знание материала';
    $grade_color = '#0F766E';
    $character_mood = 'celebrate';
} elseif ($percentage >= 70) {
    $grade = 'Хорошо';
    $grade_desc = 'Хорошее понимание темы';
    $grade_color = '#0F766E';
    $character_mood = 'happy';
} elseif ($percentage >= 50) {
    $grade = 'Удовлетворительно';
    $grade_desc = 'Достаточные знания';
    $grade_color = '#0F766E';
    $character_mood = 'thinking';
} else {
    $grade = 'Неудовлетворительно';
    $grade_desc = 'Требуется повторение урока';
    $grade_color = '#0F766E';
    $character_mood = 'thinking';
}

$today = date('d.m.Y');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат теста - ДТК Центр чтения</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar sticky-top">
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
                    <li class="nav-item"><a class="nav-link" href="test.php?id=<?= $results['test_id'] ?>">Повторить</a></li>
                    <?php if (isStaff()): ?>
                    <li class="nav-item"><a class="nav-link" href="admin/index.php">Управление</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="tests.php">Все тесты</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="card mb-4 text-white" style="background: var(--deep-teal) !important;">
            <div class="card-body d-flex align-items-center gap-4">
                <div class="character-result-animation <?= $character_mood ?>">
                    <div class="character-result-inner">
                        <div class="character-head" style="transform: scale(0.7);">
                            <div class="hair-back"></div>
                            <div class="hair"></div>
                            <div class="ear left"></div>
                            <div class="ear right"></div>
                            <div class="character-face">
                                <div class="eyebrows">
                                    <div class="eyebrow"></div>
                                    <div class="eyebrow"></div>
                                </div>
                                <div class="eyes-container">
                                    <div class="eye"><div class="pupil"></div></div>
                                    <div class="eye"><div class="pupil"></div></div>
                                </div>
                                <div class="nose"></div>
                                <div class="mouth"></div>
                            </div>
                        </div>
                    </div>
                    <div class="character-glow"></div>
                </div>
                <div>
                    <h2 class="h3">Тест завершен!</h2>
                    <p class="mb-0">Ты ответил на вопросы о <?= htmlspecialchars($results['test_title']) ?></p>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <div class="display-4"><?= $score ?>/<?= $total ?></div>
                        <p class="text-secondary">Правильных ответов</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <div class="display-4"><?= $percentage ?>%</div>
                        <p class="text-secondary">Результат</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <div class="display-4" style="color: <?= $grade_color ?>"><?= $grade ?></div>
                        <p class="text-secondary"><?= $grade_desc ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-0 shadow certificate">
            <div class="card-body text-center position-relative p-5">
                <div class="certificate-stamp position-absolute top-0 end-0 m-4 opacity-25">
                    <svg width="100" height="100"><circle cx="50" cy="50" r="45" fill="none" stroke="<?= $grade_color ?>" stroke-width="3"/>
                    <text x="50" y="55" text-anchor="middle" fill="<?= $grade_color ?>" font-size="12">ДТК</text></svg>
                </div>
                <h3 class="h4 text-primary mb-2" style="color: var(--deep-teal) !important;">СЕРТИФИКАТ</h3>
                <hr>
                <p>РЕЗУЛЬТАТ</p>
                <h2 class="display-6" style="color: <?= $grade_color ?>"><?= $grade ?></h2>
                <p>за успешное прохождение теста<br>"<?= htmlspecialchars($results['test_title']) ?>"</p>
                <div class="d-flex justify-content-center gap-4 flex-wrap">
                    <div><span class="text-secondary">Результат:</span> <strong><?= $score ?>/<?= $total ?></strong></div>
                    <div><span class="text-secondary">Процент:</span> <strong><?= $percentage ?>%</strong></div>
                    <div><span class="text-secondary">Дата:</span> <strong><?= $today ?></strong></div>
                </div>
                <hr>
                <div class="signature">
                    <div class="signature-line mx-auto" style="width:200px; height:1px; background:#000;"></div>
                    <p class="mt-2">ДТК Центр Чтения</p>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <a href="test.php?id=<?= $results['test_id'] ?>" class="card text-center text-decoration-none shadow">
                    <div class="card-body">
                        <div class="display-6" style="color: var(--deep-teal) !important;">Повторить</div>
                        <p class="text-secondary">Попробуй улучшить результат</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="index.php" class="card text-center text-decoration-none shadow">
                    <div class="card-body">
                        <div class="display-6" style="color: var(--deep-teal) !important;">На главную</div>
                        <p class="text-secondary">Вернуться домой</p>
                    </div>
                </a>
            </div>
        </div>

        <h3 class="h5 text-primary mt-5" style="color: var(--deep-teal) !important;">Подробные результаты</h3>
        <div class="list-group mb-4">
            <?php foreach ($results['questions'] as $q):
                $user_answer = isset($results['user_answers'][$q['id']]) ? $results['user_answers'][$q['id']] : -1;
                $is_correct = $user_answer === (int)$q['correct_option'];
                $correct_text = $q['option_' . chr(97 + $q['correct_option'])];
            ?>
            <div class="list-group-item list-group-item-action flex-column align-items-start <?= $is_correct ? 'list-group-item-success' : 'list-group-item-danger' ?>">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">Вопрос <?= $q['id'] ?></h6>
                    <small><?= $is_correct ? 'Правильно' : 'Неправильно' ?></small>
                </div>
                <p class="mb-1"><?= htmlspecialchars($q['question_text']) ?></p>
                <small class="text-muted">Правильный ответ: <?= htmlspecialchars($correct_text) ?></small>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p>
        </div>
    </footer>

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>