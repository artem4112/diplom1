<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ДТК Центр чтения - Интерактивное обучение</title>
    
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- ШАПКА -->
        <header class="site-header">
            <div class="header-content">
                <div class="logo-section">
                    <!-- ЛОГОТИП ДТК (нужно заменить на реальный) -->
                    <div class="logo-img-placeholder" style="width: 70px; height: 70px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--dtk-blue); font-weight: bold;">
                        ДТК
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
            <!-- БЛОК ПИСАТЕЛЯ-ЮБИЛЯРА -->
            <section class="anniversary-block">
                <div class="anniversary-content">
                    <img src="images/writer.jpg" alt="Писатель месяца" class="anniversary-image">
                    <div class="anniversary-info">
                        <h2>Писатель месяца</h2>
                        <p><strong>Александр Сергеевич Пушкин</strong></p>
                        <p>Великий русский поэт, драматург и прозаик. В этом месяце отмечаем 225 лет со дня рождения.</p>
                        
                        <div class="writer-books">
                            <h4>Рекомендуем к прочтению:</h4>
                            <ul>
                                <li>"Евгений Онегин"</li>
                                <li>"Капитанская дочка"</li>
                                <li>"Сказка о царе Салтане"</li>
                                <li>"Дубровский"</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ПЕРСОНАЖ И ДИАЛОГ -->
            <section class="character-section">
                <div class="character-container">
                    <!-- ИЗОБРАЖЕНИЕ ПЕРСОНАЖА -->
                    <div class="character-image-container">
                        <img src="images/character/char1.png" alt="Книжный помощник" id="characterImg" class="character-image" onclick="changeCharacter()">
                    </div>
                    
                    <!-- ДИАЛОГОВОЕ ОКНО -->
                    <div class="speech-bubble">
                        <div class="speech-text" id="characterText">
                            Здравствуй! Я - книжный помощник ДТК Центра чтения. Давай я расскажу тебе о нашем проекте...
                        </div>
                        
                        <div class="speech-actions">
                            <button onclick="nextStoryPart()" class="action-btn next-btn" id="nextBtn">
                                Далее
                            </button>
                            <button onclick="startLearning()" class="action-btn start-btn" id="startBtn" style="display: none;">
                                Начать обучение
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- ПРОГРЕСС РАССКАЗА -->
                <div class="story-progress">
                    <div class="progress-container">
                        <div class="progress-text" id="progressText">Часть 1 из 7: Знакомство</div>
                        <div class="progress-dots" id="progressDots">
                            <!-- Точки добавляются через JS -->
                        </div>
                    </div>
                </div>
            </section>

            <!-- ИНФОРМАЦИОННЫЕ БЛОКИ (вместо feature-list) -->
            <section class="info-blocks">
                <div class="info-block">
                    <h3>О проекте</h3>
                    <p>Интерактивная платформа ДТК Центра чтения разработана для популяризации чтения среди детей и подростков.</p>
                    <p>Проект сочетает в себе современные технологии и традиционные ценности чтения.</p>
                </div>
                
                <div class="info-block">
                    <h3>Что вас ждет</h3>
                    <ul class="info-list">
                        <li>Интерактивный урок с персонажем</li>
                        <li>10 вопросов о пользе чтения</li>
                        <li>Сертификат о прохождении</li>
                        <li>Рекомендации по чтению</li>
                    </ul>
                </div>
                
                <div class="info-block">
                    <h3>Темы теста</h3>
                    <ul class="info-list">
                        <li>Польза чтения для развития</li>
                        <li>Как выбрать книгу</li>
                        <li>Правила работы с книгой</li>
                        <li>Известные писатели</li>
                        <li>Библиотечный этикет</li>
                    </ul>
                </div>
            </section>

            <!-- КНОПКА НАЧАЛА ОБУЧЕНИЯ (появляется после рассказа) -->
            <section class="start-section" id="startSection" style="display: none;">
                <h3>Готовы начать обучение?</h3>
                <p>Персонаж завершил свой рассказ. Теперь вы можете перейти к интерактивному уроку.</p>
                <a href="lesson.php" class="primary-btn">
                    Перейти к обучению
                </a>
            </section>
        </main>

        <!-- ПОДВАЛ -->
        <footer class="site-footer">
            <div class="footer-content">
                <p>ДТК Центр чтения г. Якутск</p>
                <p>г. Якутск, ул. Ленина, 1</p>
                <p>+7 (4112) 123-456</p>
                <p>© 2024 Все права защищены</p>
                
                <div class="footer-links">
                    <a href="#privacy">Политика конфиденциальности</a>
                    <a href="#terms">Пользовательское соглашение</a>
                    <a href="#contacts">Контакты</a>
                </div>
            </div>
        </footer>
    </div>

    <script src="js/script.js"></script>
</body>
</html>