<?php
session_start();

// Проверяем, есть ли результаты теста
if (!isset($_SESSION['test_results'])) {
    header('Location: test.php');
    exit();
}

$results = $_SESSION['test_results'];
$score = $results['score'];
$total = $results['total'];
$percentage = $results['percentage'];
$user_answers = $results['user_answers'];
$questions = $results['questions'];

// Определяем оценку
if ($percentage >= 90) {
    $grade = 'Отлично';
    $grade_class = 'excellent';
    $message = 'Потрясающе! Ты настоящий книжный эксперт!';
    $character_img = 'char5.png';
} elseif ($percentage >= 70) {
    $grade = 'Хорошо';
    $grade_class = 'good';
    $message = 'Хорошая работа! Ты хорошо разбираешься в теме чтения!';
    $character_img = 'char4.png';
} elseif ($percentage >= 50) {
    $grade = 'Удовлетворительно';
    $grade_class = 'average';
    $message = 'Неплохо, но есть куда расти! Продолжай читать!';
    $character_img = 'char3.png';
} else {
    $grade = 'Попробуй еще';
    $grade_class = 'poor';
    $message = 'Не расстраивайся! Вернись к уроку и попробуй снова!';
    $character_img = 'char2.png';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты теста - ДТК Центр чтения</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Только стили для печати */
        @media print {
            .no-print { display: none !important; }
            .certificate { box-shadow: none !important; border: 3px solid #000 !important; margin: 0 !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="result-header">
            <a href="index.php" class="back-home no-print">
                <i class="fas fa-home"></i> На главную
            </a>
            <h1><i class="fas fa-award"></i> Результаты теста</h1>
            <p>Поздравляем с завершением теста!</p>
        </header>

        <main class="main-content">
            <!-- Сертификат -->
            <section class="certificate">
                <div class="certificate-content">
                    <div style="text-align: center; margin-bottom: 40px;">
                        <div class="certificate-title">СЕРТИФИКАТ</div>
                        <div style="font-size: 1.5rem; color: #7f8c8d;">ДТК Центр чтения г. Якутск</div>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="font-size: 1.8rem; color: #7f8c8d; margin-bottom: 20px;">
                            Награждается
                        </div>
                        
                        <div class="participant-name">
                            Участник обучения
                        </div>
                        
                        <div style="font-size: 1.4rem; color: #2c3e50; margin: 30px 0; line-height: 1.6;">
                            за успешное прохождение интерактивного курса<br>
                            <strong>"Удивительный мир чтения"</strong>
                        </div>
                        
                        <!-- Персонаж -->
                        <div style="display: flex; align-items: center; gap: 30px; margin: 40px 0; flex-wrap: wrap; justify-content: center;">
                            <img src="images/character/<?php echo $character_img; ?>" alt="Персонаж" style="width: 120px; height: 160px; object-fit: contain;">
                            <div style="flex: 1; min-width: 300px;">
                                <p style="font-style: italic; background: white; padding: 20px; border-radius: 10px; border-left: 5px solid #4a6fa5;">
                                    "<?php echo $message; ?>"
                                </p>
                            </div>
                        </div>
                        
                        <!-- Статистика -->
                        <div class="result-stats">
                            <div class="stat-item">
                                <div class="stat-value" style="color: <?php echo $percentage >= 70 ? '#2ecc71' : ($percentage >= 50 ? '#f39c12' : '#e74c3c'); ?>;">
                                    <?php echo $score; ?>/<?php echo $total; ?>
                                </div>
                                <div class="stat-label">Правильных ответов</div>
                            </div>
                            
                            <div class="stat-item">
                                <div class="stat-value" style="color: <?php echo $percentage >= 70 ? '#2ecc71' : ($percentage >= 50 ? '#f39c12' : '#e74c3c'); ?>;">
                                    <?php echo $percentage; ?>%
                                </div>
                                <div class="stat-label">Процент выполнения</div>
                            </div>
                            
                            <div class="stat-item">
                                <div class="stat-value" style="color: <?php echo $percentage >= 70 ? '#2ecc71' : ($percentage >= 50 ? '#f39c12' : '#e74c3c'); ?>;">
                                    <?php echo $grade; ?>
                                </div>
                                <div class="stat-label">Оценка</div>
                            </div>
                        </div>
                        
                        <!-- Подписи -->
                        <div style="margin-top: 50px; padding-top: 30px; border-top: 2px solid #ddd; display: flex; justify-content: space-between; flex-wrap: wrap;">
                            <div style="font-weight: bold;">Дата: <?php echo date('d.m.Y'); ?></div>
                            <div style="display: flex; gap: 60px;">
                                <div style="text-align: center;">
                                    <div style="width: 150px; height: 1px; background: #333; margin: 0 auto 10px;"></div>
                                    <div style="font-size: 0.9rem; color: #7f8c8d;">Директор ДТК Центра чтения</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="width: 150px; height: 1px; background: #333; margin: 0 auto 10px;"></div>
                                    <div style="font-size: 0.9rem; color: #7f8c8d;">Книжный помощник</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Кнопки -->
            <div class="action-buttons no-print">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Распечатать сертификат
                </button>
                
                <a href="index.php?restart=1" class="btn btn-success">
                    <i class="fas fa-redo"></i> Начать заново
                </a>
                
                <a href="lesson.php" class="btn btn-warning">
                    <i class="fas fa-book"></i> Повторить урок
                </a>
            </div>
            
            <!-- Разбор ошибок -->
            <?php if ($percentage < 100): ?>
            <section class="review-section no-print" style="background: white; padding: 30px; border-radius: 15px; margin: 40px 0;">
                <h2><i class="fas fa-search"></i> Разбор ошибок</h2>
                
                <?php 
                $incorrect_count = 0;
                foreach ($questions as $index => $question): 
                    $user_answer = isset($user_answers[$index]) ? $user_answers[$index] : -1;
                    
                    if ($user_answer !== $question['correct'] && $user_answer !== -1): 
                        $incorrect_count++;
                ?>
                <div class="review-item" style="border-left-color: #e74c3c;">
                    <div style="margin-bottom: 15px;">
                        <span style="background: #e74c3c; color: white; padding: 5px 15px; border-radius: 15px; font-size: 0.9rem;">
                            Вопрос <?php echo $index + 1; ?>
                        </span>
                        <h3 style="margin-top: 10px;"><?php echo $question['question']; ?></h3>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; gap: 10px; margin: 15px 0;">
                        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">
                            <strong>Ваш ответ:</strong> <?php echo $question['answers'][$user_answer]; ?>
                        </div>
                        <div style="background: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 5px;">
                            <strong>Правильный ответ:</strong> <?php echo $question['answers'][$question['correct']]; ?>
                        </div>
                    </div>
                </div>
                <?php endif; endforeach; ?>
                
                <?php if ($incorrect_count == 0): ?>
                <p style="text-align: center; color: #2ecc71; font-size: 1.2rem;">
                    <i class="fas fa-check-circle"></i> У тебя нет ошибок! Отличный результат!
                </p>
                <?php endif; ?>
            </section>
            <?php endif; ?>
        </main>

        <footer class="site-footer no-print">
            <p>© 2024 ДТК Центр чтения г. Якутск. Все права защищены.</p>
            <p>Поздравляем с завершением курса! Желаем новых книжных открытий!</p>
        </footer>
    </div>

    <script src="js/script.js"></script>
</body>
</html>