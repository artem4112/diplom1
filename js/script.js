document.addEventListener('DOMContentLoaded', function() {
    initCharacterStory();
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
            text: "Здравствуй! Я помощник ДТК Центра чтения. Сейчас пройдём тест о якутском поэте П.Н. Тобурокове.",
            title: "Часть 1 из 5: Знакомство",
            imageIndex: 0
        },
        {
            text: "Тест состоит из 8 вопросов. Вам нужно выбрать один правильный ответ из трёх вариантов.",
            title: "Часть 2 из 5: Правила теста",
            imageIndex: 1
        },
        {
            text: "Вопросы будут о биографии Тобурокова, его творчестве и основных произведениях.",
            title: "Часть 3 из 5: Темы вопросов",
            imageIndex: 2
        },
        {
            text: "После прохождения вы увидите результат и сможете распечатать сертификат.",
            title: "Часть 4 из 5: Результат",
            imageIndex: 3
        },
        {
            text: "Готовы проверить свои знания? Нажмите 'Начать тест' для перехода к вопросам.",
            title: "Часть 5 из 5: Начало",
            imageIndex: 4
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
    
    if (progressDots) {
        for (let i = 0; i < totalParts; i++) {
            const dot = document.createElement('div');
            dot.className = 'progress-dot';
            if (i === 0) dot.classList.add('active');
            progressDots.appendChild(dot);
        }
    }
    
    function updateStory() {
        if (!characterText || !progressText) return;
        
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
            if (nextBtn) nextBtn.style.display = 'none';
            if (startBtn) startBtn.style.display = 'inline-block';
        } else {
            if (nextBtn) nextBtn.style.display = 'inline-block';
            if (startBtn) startBtn.style.display = 'none';
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
    
    if (characterText && progressText) {
        updateStory();
    }
}

// Выбор ответов в тесте
document.addEventListener('DOMContentLoaded', function() {
    const answerItems = document.querySelectorAll('.answer-item');
    answerItems.forEach(item => {
        item.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                answerItems.forEach(i => i.style.background = '#f9f9f9');
                this.style.background = 'var(--dtk-light-blue)';
            }
        });
    });
});