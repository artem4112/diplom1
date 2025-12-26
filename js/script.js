// ============================================
// ОСНОВНОЙ СКРИПТ ДЛЯ ДТК ЦЕНТРА ЧТЕНИЯ
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    // ИНИЦИАЛИЗАЦИЯ РАССКАЗА ПЕРСОНАЖА
    initCharacterStory();
    
    // ИНИЦИАЛИЗАЦИЯ ПРОВЕРКИ ИЗОБРАЖЕНИЙ
    checkCharacterImages();
});

// ============ РАССКАЗ ПЕРСОНАЖА ============

function initCharacterStory() {
    // МАССИВ ИЗОБРАЖЕНИЙ ПЕРСОНАЖА
    const characterImages = [
        'images/character/char1.png',
        'images/character/char2.png',
        'images/character/char3.png',
        'images/character/char4.png',
        'images/character/char5.png'
    ];
    
    // МАССИВ ЧАСТЕЙ РАССКАЗА
    const storyParts = [
        {
            text: "Здравствуй! Я - книжный помощник ДТК Центра чтения. Давай я расскажу тебе о нашем проекте...",
            title: "Часть 1 из 7: Знакомство",
            imageIndex: 0
        },
        {
            text: "Наша платформа создана, чтобы показать, как интересно и полезно читать книги. Чтение развивает воображение, память и словарный запас.",
            title: "Часть 2 из 7: Польза чтения",
            imageIndex: 1
        },
        {
            text: "В тесте тебя ждут 10 вопросов. Например: 'Сколько минут в день рекомендуется читать детям?' или 'Что такое буккроссинг?'",
            title: "Часть 3 из 7: Вопросы теста",
            imageIndex: 2
        },
        {
            text: "Также будут вопросы о том, как выбирать книги, почему важно читать вслух и как книги помогают понимать других людей.",
            title: "Часть 4 из 7: Темы вопросов",
            imageIndex: 1
        },
        {
            text: "После прохождения теста ты получишь сертификат ДТК Центра чтения с твоим результатом. Его можно распечатать или сохранить.",
            title: "Часть 5 из 7: Сертификат",
            imageIndex: 3
        },
        {
            text: "А еще я расскажу тебе о писателях-юбилярах и посоветую интересные книги для чтения. У нас есть рекомендации для разного возраста.",
            title: "Часть 6 из 7: Рекомендации",
            imageIndex: 4
        },
        {
            text: "Отлично! Теперь ты знаешь, что тебя ждет. Готов проверить свои знания о чтении и книгах?",
            title: "Часть 7 из 7: Начало обучения",
            imageIndex: 0
        }
    ];
    
    let currentStoryIndex = 0;
    const totalParts = storyParts.length;
    
    // ЭЛЕМЕНТЫ ДЛЯ УПРАВЛЕНИЯ
    const characterImg = document.getElementById('characterImg');
    const characterText = document.getElementById('characterText');
    const progressText = document.getElementById('progressText');
    const progressDots = document.getElementById('progressDots');
    const nextBtn = document.getElementById('nextBtn');
    const startBtn = document.getElementById('startBtn');
    const startSection = document.getElementById('startSection');
    
    // СОЗДАЕМ ТОЧКИ ПРОГРЕССА
    for (let i = 0; i < totalParts; i++) {
        const dot = document.createElement('div');
        dot.className = 'progress-dot';
        if (i === 0) dot.classList.add('active');
        progressDots.appendChild(dot);
    }
    
    // ФУНКЦИЯ ОБНОВЛЕНИЯ РАССКАЗА
    function updateStory() {
        const currentPart = storyParts[currentStoryIndex];
        
        // Обновляем текст
        characterText.textContent = currentPart.text;
        progressText.textContent = currentPart.title;
        
        // Обновляем изображение персонажа
        if (characterImg) {
            characterImg.src = characterImages[currentPart.imageIndex];
        }
        
        // Обновляем точки прогресса
        const dots = document.querySelectorAll('.progress-dot');
        dots.forEach((dot, index) => {
            dot.classList.remove('active');
            if (index === currentStoryIndex) {
                dot.classList.add('active');
            }
        });
        
        // Проверяем, последняя ли часть
        if (currentStoryIndex === totalParts - 1) {
            // Последняя часть - показываем кнопку начала
            nextBtn.style.display = 'none';
            startBtn.style.display = 'inline-block';
            startSection.style.display = 'block';
        } else {
            nextBtn.style.display = 'inline-block';
            startBtn.style.display = 'none';
        }
    }
    
    // ФУНКЦИЯ ПЕРЕХОДА К СЛЕДУЮЩЕЙ ЧАСТИ
    window.nextStoryPart = function() {
        if (currentStoryIndex < totalParts - 1) {
            currentStoryIndex++;
            updateStory();
            
            // Плавная прокрутка к началу
            window.scrollTo({
                top: document.querySelector('.character-section').offsetTop - 100,
                behavior: 'smooth'
            });
        }
    };
    
    // ФУНКЦИЯ НАЧАЛА ОБУЧЕНИЯ
    window.startLearning = function() {
        window.location.href = 'lesson.php';
    };
    
    // ФУНКЦИЯ СМЕНЫ ИЗОБРАЖЕНИЯ ПЕРСОНАЖА (по клику)
    window.changeCharacter = function() {
        if (!characterImg) return;
        
        // Получаем текущий индекс изображения
        const currentSrc = characterImg.src;
        const currentIndex = characterImages.findIndex(img => currentSrc.includes(img));
        
        // Переходим к следующему изображению
        const nextIndex = (currentIndex + 1) % characterImages.length;
        characterImg.src = characterImages[nextIndex];
        
        // Анимация
        characterImg.style.transform = 'scale(1.1)';
        setTimeout(() => {
            characterImg.style.transform = 'scale(1)';
        }, 300);
    };
    
    // ИНИЦИАЛИЗИРУЕМ ПЕРВУЮ ЧАСТЬ
    updateStory();
}

// ============ ПРОВЕРКА ИЗОБРАЖЕНИЙ ============

function checkCharacterImages() {
    console.log('Проверка изображений для ДТК Центра чтения...');
    
    // Проверяем изображения персонажа
    const characterImages = [
        'images/character/char1.png',
        'images/character/char2.png',
        'images/character/char3.png',
        'images/character/char4.png',
        'images/character/char5.png'
    ];
    
    let loadedCount = 0;
    const totalImages = characterImages.length + 1; // +1 для писателя
    
    // Функция для проверки загрузки
    function checkImage(src, name) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = function() {
                console.log(`✓ Загружено: ${name}`);
                loadedCount++;
                resolve(true);
            };
            img.onerror = function() {
                console.warn(`⚠ Не удалось загрузить: ${name}`);
                loadedCount++;
                resolve(false);
            };
            img.src = src;
        });
    }
    
    // Проверяем все изображения
    Promise.all([
        checkImage('images/writer.jpg', 'Изображение писателя'),
        ...characterImages.map((src, index) => checkImage(src, `Персонаж ${index + 1}`))
    ]).then(results => {
        const successCount = results.filter(r => r).length;
        console.log(`Загружено ${successCount} из ${totalImages} изображений`);
        
        if (successCount === totalImages) {
            console.log('✅ Все изображения успешно загружены');
        } else if (successCount >= 3) {
            console.log('⚠ Некоторые изображения не загрузились, но работа продолжается');
        } else {
            console.error('❌ Слишком много изображений не загрузилось');
        }
    });
}

// ============ ДЛЯ СТРАНИЦЫ УРОКА ============

function initLessonCharacter() {
    const lessonCharacter = document.querySelector('.lesson-character');
    if (!lessonCharacter) return;
    
    const lessonImages = [
        'images/character/char1.png',
        'images/character/char2.png', 
        'images/character/char3.png',
        'images/character/char4.png',
        'images/character/char5.png'
    ];
    
    let lessonIndex = 0;
    
    window.animateCharacter = function() {
        lessonCharacter.style.transform = 'scale(1.1)';
        setTimeout(() => {
            lessonCharacter.style.transform = 'scale(1)';
        }, 300);
    };
    
    window.changeLessonCharacter = function() {
        lessonIndex = (lessonIndex + 1) % lessonImages.length;
        lessonCharacter.src = lessonImages[lessonIndex];
        
        lessonCharacter.style.opacity = '0.5';
        setTimeout(() => {
            lessonCharacter.style.opacity = '1';
        }, 150);
    };
    
    if (lessonCharacter) {
        lessonCharacter.addEventListener('click', animateCharacter);
    }
}

// ============ ДЛЯ СТРАНИЦЫ ТЕСТА ============

function initTest() {
    const testForm = document.getElementById('testForm');
    if (!testForm) return;
    
    // Выбор ответов
    document.querySelectorAll('.answer-option').forEach(option => {
        option.addEventListener('click', function() {
            const questionBlock = this.closest('.question-block');
            questionBlock.querySelectorAll('.answer-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            this.classList.add('selected');
            
            const radioInput = this.querySelector('input[type="radio"]');
            if (radioInput) {
                radioInput.checked = true;
            }
        });
    });
    
    // Проверка перед отправкой
    testForm.addEventListener('submit', function(e) {
        const questionBlocks = document.querySelectorAll('.question-block');
        let allAnswered = true;
        
        questionBlocks.forEach(block => {
            const radioInputs = block.querySelectorAll('input[type="radio"]:checked');
            if (radioInputs.length === 0) {
                allAnswered = false;
                block.style.borderColor = 'var(--dtk-red)';
            } else {
                block.style.borderColor = 'var(--dtk-light-blue)';
            }
        });
        
        if (!allAnswered) {
            e.preventDefault();
            alert('Пожалуйста, ответьте на все вопросы перед отправкой теста.');
            
            // Прокручиваем к первому неотвеченному
            const firstUnanswered = document.querySelector('.question-block[style*="border-color: var(--dtk-red)"]');
            if (firstUnanswered) {
                firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
}