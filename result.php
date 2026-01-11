<?php
session_start();
if (!isset($_SESSION['test_results'])) {
    header('Location: test.php');
    exit();
}
$results = $_SESSION['test_results'];
$score = $results['score'];
$total = $results['total'];
$percentage = $results['percentage'];
if ($percentage >= 90) {
    $grade = 'Эксперт';
    $character_img = 'char5.png';
} elseif ($percentage >= 70) {
    $grade = 'Знаток';
    $character_img = 'char4.png';
} elseif ($percentage >= 50) {
    $grade = 'Ученик';
    $character_img = 'char3.png';
} else {
    $grade = 'Новичок';
    $character_img = 'char2.png';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат - ДТК</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="result-header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-img-placeholder">
                        <img src="images/logo.png" alt="ДТК" class="logo">
                    </div>
                    <div class="logo-text">
                        <h1>Результат теста</h1>
                    </div>
                </div>
                <nav class="site-nav">
                    <a href="index.php" class="nav-link">Главная</a>
                </nav>
            </div>
        </header>
        <main class="result-content">
            <div class="result-card">
                <h2>Твой результат</h2>
                <div class="result-stats">
                    <div class="stat-item">
                        <div class="stat-value"><?php echo $score; ?>/<?php echo $total; ?></div>
                        <div class="stat-label">Ответы</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo $percentage; ?>%</div>
                        <div class="stat-label">Процент</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value"><?php echo $grade; ?></div>
                        <div class="stat-label">Звание</div>
                    </div>
                </div>
                <div class="result-character">
                    <img src="images/character/<?php echo $character_img; ?>" alt="Макс">
                </div>
                <div class="result-actions">
                    <a href="test.php" class="action-btn retry-btn">Ещё раз</a>
                    <a href="lesson.php" class="action-btn lesson-btn">Урок</a>
                    <a href="index.php" class="action-btn home-btn">Главная</a>
                    <a href="javascript:void(0);" onclick="printCertificate()" class="action-btn print-btn">Сертификат</a>
                </div>
            </div>
        </main>
        <footer class="site-footer">
            <div class="footer-content">
                <p>ДТК Центр чтения г. Якутск</p>
            </div>
        </footer>
    </div>
    <script src="js/script.js"></script>
</body>
</html>