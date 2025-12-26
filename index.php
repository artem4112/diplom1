<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ДТК Центр чтения - диплом модуль</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="site-header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-img-placeholder">
                        <img src="logo.png" alt="logo" class="logo">
                    </div>
                    <div class="logo-text">
                        <h1>ДТК Центр чтения</h1>
                        <p class="city">г. Якутск</p>
                    </div>
                </div>
                
                <nav class="site-nav">
                    <a href="index.php" class="nav-link">Главная</a>
                    <a href="lesson.php" class="nav-link">Обучение</a>
                    <a href="test.php" class="nav-link">Тест</a>
                    <a href="#about" class="nav-link">О проекте</a>
                </nav>
            </div>
        </header>

        <main class="main-content">
            <section class="anniversary-block">
                <div class="anniversary-content">
                    <img src="images/writer.jpg" alt="Писатель месяца" class="anniversary-image">
                    <div class="anniversary-info">
                        <h2>Писатель месяца</h2>
                        <p><strong>Пётр Николаевич Тобуроков</strong></p>
                        <p>якутский писатель, народный поэт Якутии. 25 лет годовщина. 110 лет</p>
                        
                        <div class="writer-books">
                            <h4>Рекомендуем к прочтению:</h4>
                            <ul>
                                <li>"На берегах Вилюя"</li>
                                <li>"Долина белых журавлей"</li>
                                <li>"Искры снега"</li>
                                <li>"Цветы на снегу"</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section class="character-section">
                <div class="character-container">
                    <div class="character-image-container">
                        <img src="images/character/char1.png" alt="перс" id="characterImg" class="character-image" onclick="changeCharacter()">
                    </div>
                    
                    <div class="speech-bubble">
                        <div class="speech-text" id="characterText">
                            ку я перс ДТК Центра чтения 123 фывйцу
                        </div>
                        
                        <div class="speech-actions">
                            <button onclick="nextStoryPart()" class="action-btn next-btn" id="nextBtn">
                                Далее
                            </button>
                            <button onclick="startLearning()" class="action-btn start-btn" id="startBtn" style="display: none;">
                                Пройти тест
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="story-progress">
                    <div class="progress-container">
                        <div class="progress-text" id="progressText">Часть 1 из 7: Знакомство</div>
                        <div class="progress-dots" id="progressDots"></div>
                    </div>
                </div>
            </section>

            <section class="info-blocks">
                <div class="info-block">
                    <h3>О проекте</h3>
                    <p>дипломный проект</p>
                    <p>123123</p>
                </div>
                
                <div class="info-block">
                    <h3>Структура</h3>
                    <ul class="info-list">
                        <li>попытка выложить в гит</li>
                        <li>123123asdasd</li>
                    </ul>
                </div>
                
                <div class="info-block">
                    <h3>Тема теста</h3>
                    <ul class="info-list">
                        <li>Юбиляр</li>
                        <li>о книге</li>
                        <li>123123</li>
                    </ul>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="footer-content">
                <p>ДТК Центр чтения</p>
                <p>+7 (914) 234 78 56</p>
            </div>
        </footer>
    </div>

    <script src="js/script.js"></script>
</body>
</html>