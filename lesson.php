<?php
session_start();

$lesson = [
    'title' => 'Материал: П.Н. Тобуроков',
    'parts' => [
        [
            'title' => 'Биография',
            'content' => 'Пётр Николаевич Тобуроков (1914-1977) - якутский писатель, народный поэт Якутии. Родился в Вилюйском районе.',
            'character_img' => 'char1.png'
        ],
        [
            'title' => 'Творчество',
            'content' => 'Основные темы: природа Якутии, жизнь народа, философские размышления. Писал стихи, поэмы, прозу.',
            'character_img' => 'char2.png'
        ],
        [
            'title' => 'Известные произведения',
            'content' => '«На берегах Вилюя», «Долина белых журавлей», «Искры снега», «Цветы на снегу».',
            'character_img' => 'char3.png'
        ],
        [
            'title' => 'Наследие',
            'content' => 'В 2024 году исполняется 110 лет со дня рождения. Его творчество изучается в школах Якутии.',
            'character_img' => 'char4.png'
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
    <title>Материал: Тобуроков - ДТК Центр чтения</title>
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
                    <a href="index.php" class="nav-link">Начало</a>
                    <a href="test.php" class="nav-link">Тест</a>
                </nav>
            </div>
        </header>

        <main class="main-content">
            <div class="lesson-content">
                <div class="lesson-character-section">
                    <div class="lesson-character-image">
                        <img src="images/character/<?php echo $current_lesson['character_img']; ?>" alt="Персонаж">
                    </div>
                    
                    <div class="lesson-text">
                        <h2><?php echo $current_lesson['title']; ?></h2>
                        <p><?php echo $current_lesson['content']; ?></p>
                    </div>
                </div>
                
                <div class="lesson-navigation">
                    <?php if ($current_part > 0): ?>
                    <a href="lesson.php?part=<?php echo $current_part - 1; ?>" class="lesson-nav-btn prev-btn">
                        Назад
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($current_part < count($lesson['parts']) - 1): ?>
                    <a href="lesson.php?part=<?php echo $current_part + 1; ?>" class="lesson-nav-btn next-btn">
                        Далее
                    </a>
                    <?php else: ?>
                    <a href="test.php" class="lesson-nav-btn test-btn">
                        Перейти к тесту
                    </a>
                    <?php endif; ?>
                </div>
                
                <div class="lesson-progress">
                    <p>Шаг <?php echo $current_part + 1; ?> из <?php echo count($lesson['parts']); ?></p>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo (($current_part + 1) / count($lesson['parts'])) * 100; ?>%"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>