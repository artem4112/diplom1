<?php
require_once 'config.php';

if (!isUserLoggedIn()) {
    header('Location: user_login.php?redirect=index.php');
    exit();
}

$user_completed = getUserCompletedTestsCount($pdo, $_SESSION['user_id']);
$totalTests = $pdo->query("SELECT COUNT(*) FROM tests")->fetchColumn();
$firstTest = $pdo->query("SELECT id FROM tests ORDER BY sort_order ASC, created_at DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ДТК Центр чтения – интерактивное обучение</title>
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/logo.png" alt="ДТК" width="40" height="40" class="me-2">
                <div>
                    <h1 class="h5 mb-0">ДТК Центр чтения</h1>
                    <small class="text-white-50">г. Якутск</small>
                </div>
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
            <div class="col-md-5">
                <div class="character-station">
                    <div class="character-platform">
                        <div class="character-main" id="characterContainer">
                            <div class="character-body" id="characterBody">
                                <div class="character-head">
                                    <div class="hair-back"></div>
                                    <div class="hair"></div>
                                    <div class="ear left"></div>
                                    <div class="ear right"></div>
                                    <div class="character-face">
                                        <div class="eyebrows">
                                            <div class="eyebrow left-brow" id="leftBrow"></div>
                                            <div class="eyebrow right-brow" id="rightBrow"></div>
                                        </div>
                                        <div class="eyes-container">
                                            <div class="eye left-eye" id="leftEye">
                                                <div class="eyelid"></div>
                                                <div class="pupil" id="leftPupil"></div>
                                            </div>
                                            <div class="eye right-eye" id="rightEye">
                                                <div class="eyelid"></div>
                                                <div class="pupil" id="rightPupil"></div>
                                            </div>
                                        </div>
                                        <div class="nose"></div>
                                        <div class="mouth-container">
                                            <div class="mouth" id="characterMouth"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="character-torso">
                                    <div class="arm left-arm" id="leftArm"></div>
                                    <div class="arm right-arm" id="rightArm"></div>
                                </div>
                            </div>
                            <div class="character-shadow"></div>
                        </div>
                    </div>
                </div>

                <div class="progress-card mt-4 p-3 bg-white rounded-3 shadow-sm">
                    <h6 class="mb-2" style="color: var(--deep-teal);">
                        Ваш прогресс, <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </h6>
                    <div class="progress mb-2" style="height: 10px;">
                        <div id="globalProgressBar" class="progress-bar" role="progressbar" style="width: <?= round(($user_completed / max($totalTests, 1)) * 100) ?>%; background-color: var(--deep-teal);"></div>
                    </div>
                    <div class="d-flex justify-content-between small text-secondary">
                        <span>Пройдено тестов: <span id="completedTestsCount"><?= $user_completed ?></span> из <span id="totalTestsCount"><?= $totalTests ?></span></span>
                        <span id="progressPercent"><?= round(($user_completed / max($totalTests, 1)) * 100) ?>%</span>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card shadow-lg border-0 welcome-card">
                    <div class="card-body p-4">
                        <h3 class="card-title text-primary">Добро пожаловать в мир литературы</h3>
                        <div id="welcomeText" class="card-text lead mt-3" style="min-height: 150px; font-size: 1.1rem;"></div>
                        <!-- Кнопки теперь видны сразу, без ожидания печати -->
                        <div class="d-flex gap-3 mt-4" id="actionButtons">
                            <?php if ($firstTest): ?>
                            <a href="test.php?id=<?= $firstTest['id'] ?>" class="btn btn-primary btn-lg flex-grow-1">Начать тест</a>
                            <?php endif; ?>
                            <a href="tests.php" class="btn btn-outline-primary btn-lg flex-grow-1">К тестам</a>
                        </div>
                        <hr class="my-4">
                        <div class="text-secondary small text-center">
                            <span>Пройди тест – получи сертификат</span>
                            <span class="mx-2">|</span>
                            <span>Узнай больше о писателях</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mb-4 text-center mt-5" style="color: var(--deep-teal);">Основные тесты</h2>
        <div class="row g-4">
            <?php
            $stmt = $pdo->query("SELECT * FROM tests ORDER BY sort_order ASC, created_at DESC LIMIT 4");
            $featured_tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $i = 0;
            foreach ($featured_tests as $test): $i++; ?>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 text-center shadow-sm test-card">
                    <div class="card-body d-flex flex-column">
                        <div class="test-icon mb-3">
                            <?php if (!empty($test['image_path'])): ?>
                                <img src="<?= htmlspecialchars($test['image_path']) ?>" alt="Фото писателя" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <img src="images/image<?= $i ?>.png" alt="Писатель" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                            <?php endif; ?>
                        </div>
                        <h5 class="card-title"><?= htmlspecialchars($test['title']) ?></h5>
                        <p class="card-text small text-secondary"><?= nl2br(htmlspecialchars(mb_substr($test['description'], 0, 100))) ?></p>
                        <a href="test.php?id=<?= $test['id'] ?>" class="btn btn-outline-primary mt-auto stretched-link">Пройти тест</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-white-50 small">© <?= date('Y') ?> ДТК Центр чтения. Интерактивный образовательный модуль.</p>
        </div>
    </footer>

    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        const welcomeMessage = "Привет! Я Макс, твой проводник в удивительный мир книг и знаний. Здесь ты найдёшь тесты о писателях, интересные факты. Готов отправиться в приключение? Нажми на кнопку и проверь свои силы!";
        let currentChar = 0;
        let isTyping = false;
        const container = document.getElementById('welcomeText');

        function typeNextChar() {
            if (!container) return;
            if (currentChar < welcomeMessage.length) {
                isTyping = true;
                container.innerHTML += welcomeMessage[currentChar];
                currentChar++;
                if (window.dtkCharacter) {
                    window.dtkCharacter.startTalking();
                }
                if (currentChar % 15 === 0 && window.dtkCharacter) {
                    window.dtkCharacter.playAnimation('jump');
                }
                if (currentChar % 25 === 0 && window.dtkCharacter) {
                    window.dtkCharacter.playAnimation('wave');
                }
                setTimeout(typeNextChar, 50);
            } else {
                isTyping = false;
                if (window.dtkCharacter) {
                    window.dtkCharacter.stopTalking();
                    window.dtkCharacter.playAnimation('celebrate');
                    window.dtkCharacter.setMood('celebrate');
                }
                // Кнопки уже показаны, ничего не делаем
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (window.dtkCharacter) {
                    window.dtkCharacter.playAnimation('wave');
                    window.dtkCharacter.setMood('happy');
                }
                typeNextChar();
            }, 500);
        });
    </script>
</body>
</html>