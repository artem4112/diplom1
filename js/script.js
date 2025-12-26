document.addEventListener('DOMContentLoaded', function() {
    initCharacterStory();
    checkCharacterImages();
});

function initCharacterStory() {
    const characterImages = [
        'images/character/char1.png',
        'images/character/char2.png',
        'images/character/char3.png',
        'images/character/char4.png',
        'images/character/char5.png'
    ];
    
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
    
    const characterImg = document.getElementById('characterImg');
    const characterText = document.getElementById('characterText');
    const progressText = document.getElementById('progressText');
    const progressDots = document.getElementById('progressDots');
    const nextBtn = document.getElementById('nextBtn');
    const startBtn = document.getElementById('startBtn');
    
    for (let i = 0; i < totalParts; i++) {
        const dot = document.createElement('div');
        dot.className = 'progress-dot';
        if (i === 0) dot.classList.add('active');
        progressDots.appendChild(dot);
    }
    
    function updateStory() {
        const currentPart = storyParts[currentStoryIndex];
        
        characterText.textContent = currentPart.text;
        progressText.textContent = currentPart.title;
        
        if (characterImg) {
            characterImg.src = characterImages[currentPart.imageIndex];
        }
        
        const dots = document.querySelectorAll('.progress-dot');
        dots.forEach((dot, index) => {
            dot.classList.remove('active');
            if (index === currentStoryIndex) {
                dot.classList.add('active');
            }
        });
        
        if (currentStoryIndex === totalParts - 1) {
            nextBtn.style.display = 'none';
            startBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            startBtn.style.display = 'none';
        }
    }
    
    window.nextStoryPart = function() {
        if (currentStoryIndex < totalParts - 1) {
            currentStoryIndex++;
            updateStory();
            
            window.scrollTo({
                top: document.querySelector('.character-section').offsetTop - 100,
                behavior: 'smooth'
            });
        }
    };
    
    window.startLearning = function() {
        window.location.href = 'lesson.php';
    };
    
    window.changeCharacter = function() {
        if (!characterImg) return;
        
        const currentSrc = characterImg.src;
        const currentIndex = characterImages.findIndex(img => currentSrc.includes(img));
        const nextIndex = (currentIndex + 1) % characterImages.length;
        characterImg.src = characterImages[nextIndex];
        
        characterImg.style.transform = 'scale(1.1)';
        setTimeout(() => {
            characterImg.style.transform = 'scale(1)';
        }, 300);
    };
    
    updateStory();
}

function checkCharacterImages() {
    console.log('Проверка изображений для ДТК Центра чтения...');
    
    const characterImages = [
        'images/character/char1.png',
        'images/character/char2.png',
        'images/character/char3.png',
        'images/character/char4.png',
        'images/character/char5.png'
    ];
    
    let loadedCount = 0;
    const totalImages = characterImages.length + 1;
    
    function checkImage(src, name) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = function() {
                loadedCount++;
                resolve(true);
            };
            img.onerror = function() {
                loadedCount++;
                resolve(false);
            };
            img.src = src;
        });
    }
    
    Promise.all([
        checkImage('images/writer.jpg', 'Изображение писателя'),
        ...characterImages.map((src, index) => checkImage(src, `Персонаж ${index + 1}`))
    ]).then(results => {
        const successCount = results.filter(r => r).length;
    });
}