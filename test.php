<?php
require_once 'config.php';

if (!isUserLoggedIn()) {
    header('Location: user_login.php?redirect=test.php?id=' . (int)($_GET['id'] ?? 0));
    exit();
}

unset($_SESSION['result_saved']);
unset($_SESSION['saved_test_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_id = (int)$_POST['test_id'];
    $test = getTest($pdo, $test_id);
    if (!$test) die('Тест не найден');
    $questions = getQuestions($pdo, $test_id);
    
    $score = 0;
    $user_answers = [];
    foreach ($questions as $q) {
        $answer = isset($_POST['q' . $q['id']]) ? (int)$_POST['q' . $q['id']] : -1;
        $user_answers[$q['id']] = $answer;
        if ($answer === (int)$q['correct_option']) {
            $score++;
        }
    }
    $total = count($questions);
    $percentage = round(($score / $total) * 100);
    
    $user_id = $_SESSION['user_id'];
    $user_data = getUserById($pdo, $user_id);
    $user_name = $user_data['full_name'];
    $user_email = $user_data['email'] ?? '';
    saveTestResult($pdo, $test_id, $user_name, $user_email, $score, $total, $percentage, $user_id);
    
    $_SESSION['test_results'] = [
        'test_id' => $test_id,
        'test_title' => $test['title'],
        'score' => $score,
        'total' => $total,
        'percentage' => $percentage,
        'questions' => $questions,
        'user_answers' => $user_answers
    ];
    header('Location: result.php');
    exit();
}

$test_id = (int)$_GET['id'];
$test = getTest($pdo, $test_id);
if (!$test) die('Тест не найден');
$questions = getQuestions($pdo, $test_id);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест: <?= htmlspecialchars($test['title']) ?> - ДТК Центр чтения</title>
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
                    <li class="nav-item"><a class="nav-link" href="tests.php">Все тесты</a></li>
                    <?php if (isStaff()): ?>
                    <li class="nav-item"><a class="nav-link" href="admin/index.php">Управление</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="card mb-4 text-white" style="background: var(--deep-teal) !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="test-character">
                    <div class="test-character-inner">
                        <div class="character-head" style="transform: scale(0.6);">
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
                </div>
                <div>
                    <h2 class="h4">Тест-викторина</h2>
                    <p class="mb-1"><?= count($questions) ?> вопросов о <?= htmlspecialchars($test['title']) ?></p>
                </div>
            </div>
        </div>

        <div class="progress mb-4" style="height: 6px;">
            <div class="progress-bar" id="testProgressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="alert alert-info">
            <h5 class="alert-heading">Как проходит тест?</h5>
            <p class="mb-0">Отвечайте на вопросы, выбирая один вариант.<br/>Если ответ сложный прикрепляется подсказка.</p>
        </div>

        <form method="post" id="testForm">
            <input type="hidden" name="test_id" value="<?= $test_id ?>">
            <?php foreach ($questions as $index => $q): ?>
            <div class="card mb-4 shadow-sm test-question-card">
                <div class="card-header bg-light d-flex justify-content-between">
                    <span>Вопрос <?= $index + 1 ?> из <?= count($questions) ?></span>
                    <span class="badge bg-warning text-dark">Бланк с вопросом</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($q['question_text']) ?></h5>
                    <div class="list-group mt-3">
                        <?php foreach (['A', 'B', 'C'] as $i => $letter): 
                            $option = $q['option_'.strtolower($letter)]; ?>
                        <label class="list-group-item d-flex align-items-center">
                            <input type="radio" name="q<?= $q['id'] ?>" value="<?= $i ?>" class="form-check-input me-3" required>
                            <span class="me-2 fw-bold"><?= $letter ?>.</span> <?= htmlspecialchars($option) ?>
                        </label>
                        <?php endforeach; ?>
                    </div>
                    <?php if (!empty($q['hint'])): ?>
                    <div class="alert alert-warning mt-3 small">
                        [Подсказка] <?= htmlspecialchars($q['hint']) ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="text-center my-5">
                <button type="submit" class="btn btn-primary btn-lg px-5">Завершить тест</button>
                <p class="text-secondary mt-2">После отправки увидите результат и сертификат</p>
            </div>
        </form>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-white-50 small">Интерактивный образовательный модуль.</p>
        </div>
    </footer>

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.enhancedMascot) {
            setTimeout(() => {
                window.enhancedMascot.showMessage("Не торопись, читай вопросы внимательно!", 4000);
            }, 2000);
        }
    });
    </script>
</body>
</html>