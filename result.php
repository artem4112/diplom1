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
    $grade = 'Тобуроков';
    $message = 'Тобуроков';
    $character_img = 'char5.png';
} elseif ($percentage >= 70) {
    $grade = '123123';
    $message = 'фывфыв';
    $character_img = 'char4.png';
} elseif ($percentage >= 50) {
    $grade = 'брух';
    $message = 'брух';
    $character_img = 'char3.png';
} else {
    $grade = 'ретрай';
    $message = 'ретрай';
    $character_img = 'char2.png';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результат теста - ДТК Центр чтения</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="result-header">
            <a href="index.php" class="back-home">
                глав
            </a>
            <h1>Результат теста</h1>
            <p>Тема Тобуроков юбиляр</p>
        </header>

        <main class="result-content">
            <div class="result-card">
                <h2>Ваш результат</h2>
                
                <div class="result-stats">
                    <div class="stat-item">
                        <div class="stat-value"><?php echo $score; ?>/<?php echo $total; ?></div>
                        <div class="stat-label">Правильных ответов</div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-value"><?php echo $percentage; ?>%</div>
                        <div class="stat-label">Процент выполнения</div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-value"><?php echo $grade; ?></div>
                        <div class="stat-label">Оценка</div>
                    </div>
                </div>
                
                <div class="result-message">
                    <p><?php echo $message; ?></p>
                </div>
                
                <div class="result-character">
                    <img src="images/character/<?php echo $character_img; ?>" alt="Персонаж">
                </div>
                
                <div class="result-actions">
                    <a href="test.php" class="action-btn retry-btn">тест ретрай</a>
                    <a href="lesson.php" class="action-btn lesson-btn">урок ретрай</a>
                </div>
                
                <div class="result-date">
                    <p>ДТК Центр чтения г. Якутск</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>