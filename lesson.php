<?php
session_start();

$lesson = [
    'title' => 'Интерактивный урок о чтении',
    'parts' => [
        [
            'title' => 'Введение',
            'content' => 'Добро пожаловать на интерактивный урок ДТК Центра чтения. Сегодня мы поговорим о важности чтения в нашей жизни.',
            'character_img' => 'char1.png'
        ],
        [
            'title' => 'Польза чтения',
            'content' => 'Регулярное чтение развивает мышление, улучшает память и концентрацию. Читающие люди имеют больший словарный запас и лучше формулируют мысли.',
            'character_img' => 'char2.png'
        ],
        [
            'title' => 'Как выбирать книги',
            'content' => 'Выбирайте книги по интересам, читайте аннотации и отзывы. Не судите книгу по обложке - иногда скромные издания содержат гениальные произведения.',
            'character_img' => 'char3.png'
        ],
        [
            'title' => 'Работа с книгой',
            'content' => 'При чтении делайте заметки, выписывайте интересные мысли. Если встречаете непонятное слово - ищите его значение в словаре.',
            'character_img' => 'char4.png'
        ],
        [
            'title' => 'Завершение урока',
            'content' => 'Вы отлично справились с уроком! Теперь вы знаете больше о пользе чтения и работе с книгами. Готовы проверить свои знания?',
            'character_img' => 'char5.png'
        ]
    ]
];

$current_part = isset($_GET['part']) ? intval($_GET['part']) : 0;
if ($current_part >= count($lesson['parts'])) $current_part = count($lesson['parts']) - 1;
$current_lesson = $lesson['parts'][$current_part];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Урок: <?php echo $lesson['title']; ?> - ДТК Центр чтения</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="lesson-header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-img-placeholder">
                        ДТК
                    </div>
                    <div class="logo-text">
                        <h1><?php echo $lesson['title']; ?></h1>
                    </div>
                </div>
                
                <nav class="site-nav">
                    <a href="index.php" class="nav-link">Главная</a>
                    <a href="test.php" class="nav-link">Тест</a>
                </nav>
            </div>
        </header>

        <main class="main-content">
            <div class="lesson-content">
                <div class="character-container">
                    <div class="character-image-container">
                        <img src="images/character/<?php echo $current_lesson['character_img']; ?>" 
                             alt="Персонаж" 
                             class="character-image lesson-character"
                             onclick="animateCharacter()">
                    </div>
                    
                    <div class="speech-bubble">
                        <div class="speech-text">
                            <h3><?php echo $current_lesson['title']; ?></h3>
                            <p><?php echo $current_lesson['content']; ?></p>
                        </div>
                        
                        <div class="speech-actions">
                            <?php if ($current_part > 0): ?>
                            <a href="lesson.php?part=<?php echo $current_part - 1; ?>" class="action-btn">
                                Назад
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($current_part < count($lesson['parts']) - 1): ?>
                            <a href="lesson.php?part=<?php echo $current_part + 1; ?>" class="action-btn next-btn">
                                Далее
                            </a>
                            <?php else: ?>
                            <a href="test.php" class="action-btn" style="background: var(--dtk-red);">
                                Перейти к тесту
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="story-progress">
                    <div class="progress-container">
                        <div class="progress-text">
                            Шаг <?php echo $current_part + 1; ?> из <?php echo count($lesson['parts']); ?>
                        </div>
                        <div class="progress-dots">
                            <?php for ($i = 0; $i < count($lesson['parts']); $i++): ?>
                            <div class="progress-dot <?php echo $i == $current_part ? 'active' : ''; ?>"></div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="site-footer">
            <div class="footer-content">
                <p>ДТК Центр чтения г. Якутск - Интерактивное обучение</p>
                <p>© 2024 Все права защищены</p>
            </div>
        </footer>
    </div>

    <script src="js/script.js"></script>
</body>
</html>