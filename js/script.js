document.addEventListener('DOMContentLoaded', function() {
    initAnimatedCharacter();
    initQuizInteractions();
});

function initAnimatedCharacter() {
    const storyConfig = {
        parts: [
            {text: "Привет! Я Макс.", image: 'char1.png'},
            {text: "Сегодня изучаем Тобурокова.", image: 'char2.png'},
            {text: "Он писал о природе Якутии.", image: 'char3.png'},
            {text: "Пройди урок и тест.", image: 'char4.png'},
            {text: "Готов начать?", image: 'char5.png'}
        ],
        currentIndex: 0,
        isTyping: false
    };
    const characterImg = document.getElementById('characterImg');
    const characterText = document.getElementById('characterText');
    const nextBtn = document.getElementById('nextBtn');
    const startBtn = document.getElementById('startBtn');
    const progressText = document.getElementById('progressText');
    const progressDots = document.getElementById('progressDots');
    function initProgressDots() {
        if (!progressDots) return;
        progressDots.innerHTML = '';
        for (let i = 0; i < storyConfig.parts.length; i++) {
            const dot = document.createElement('div');
            dot.className = 'progress-dot';
            if (i === 0) dot.classList.add('active');
            progressDots.appendChild(dot);
        }
    }
    function typeWriter(text, element, callback) {
        storyConfig.isTyping = true;
        element.innerHTML = '';
        element.classList.add('typing');
        let i = 0;
        const speed = 50;
        function typeCharacter() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(typeCharacter, speed);
            } else {
                element.classList.remove('typing');
                storyConfig.isTyping = false;
                if (callback) callback();
            }
        }
        typeCharacter();
    }
    function updateStory() {
        if (storyConfig.isTyping) return;
        const currentPart = storyConfig.parts[storyConfig.currentIndex];
        if (characterImg) {
            characterImg.src = `images/character/${currentPart.image}`;
        }
        if (characterText) {
            characterText.innerHTML = '';
            setTimeout(() => {
                typeWriter(currentPart.text, characterText);
            }, 100);
        }
        if (progressText) {
            progressText.textContent = `Часть ${storyConfig.currentIndex + 1} из 5`;
        }
        const dots = document.querySelectorAll('.progress-dot');
        dots.forEach((dot, index) => {
            dot.classList.remove('active');
            if (index === storyConfig.currentIndex) {
                dot.classList.add('active');
            }
        });
        if (nextBtn && startBtn) {
            if (storyConfig.currentIndex === storyConfig.parts.length - 1) {
                nextBtn.style.display = 'none';
                startBtn.style.display = 'inline-block';
            } else {
                nextBtn.style.display = 'inline-block';
                startBtn.style.display = 'none';
            }
        }
    }
    function setupCharacterInteractions() {
        if (characterImg) {
            characterImg.addEventListener('click', function() {
                this.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 300);
            });
        }
    }
    initProgressDots();
    updateStory();
    setupCharacterInteractions();
    window.nextStoryPart = function() {
        if (storyConfig.isTyping || storyConfig.currentIndex >= storyConfig.parts.length - 1) return;
        storyConfig.currentIndex++;
        updateStory();
        setTimeout(() => {
            const speechBubble = document.querySelector('.speech-bubble');
            if (speechBubble) {
                speechBubble.scrollIntoView({behavior: 'smooth', block: 'end'});
            }
        }, 100);
    };
    window.startLearning = function() {
        if (storyConfig.isTyping) return;
        window.location.href = 'lesson.php';
    };
    window.changeCharacter = function() {
        if (storyConfig.isTyping) return;
        const currentSrc = characterImg.src;
        const currentIndex = storyConfig.parts.findIndex(part => 
            currentSrc.includes(part.image)
        );
        const nextIndex = (currentIndex + 1) % storyConfig.parts.length;
        characterImg.src = `images/character/${storyConfig.parts[nextIndex].image}`;
    };
}

function initQuizInteractions() {
    const answerItems = document.querySelectorAll('.answer-item');
    answerItems.forEach(item => {
        item.addEventListener('click', function() {
            answerItems.forEach(i => {
                i.style.background = '#f9f9f9';
            });
            this.style.background = '#E6F2FF';
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
        });
    });
}

function printCertificate() {
    const today = new Date();
    const dateStr = today.toLocaleDateString('ru-RU');
    const gradeElement = document.querySelector('.stat-value:last-child');
    const grade = gradeElement ? gradeElement.textContent : 'Знаток';
    const scoreElement = document.querySelector('.stat-value:first-child');
    const score = scoreElement ? scoreElement.textContent : '0/8';
    const percentElement = document.querySelectorAll('.stat-value')[1];
    const percent = percentElement ? percentElement.textContent : '0%';
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Сертификат</title>
            <style>
                body { font-family: Segoe UI; padding: 40px; text-align: center; }
                .certificate { border: 10px solid #0066CC; padding: 40px; }
                h1 { color: #004C99; }
                .grade { font-size: 36px; color: #CC3333; margin: 20px; }
                .info { margin: 20px; }
                button { background: #28a745; color: white; border: none; padding: 12px 25px; margin: 10px; cursor: pointer; }
            </style>
        </head>
        <body>
            <div class="certificate">
                <h1>СЕРТИФИКАТ</h1>
                <p>ДТК Центр чтения г. Якутск</p>
                <div class="grade">${grade}</div>
                <div class="info">
                    <p>Результат: ${score}</p>
                    <p>Процент: ${percent}</p>
                    <p>Дата: ${dateStr}</p>
                </div>
            </div>
            <button onclick="window.print()">Печать</button>
            <button onclick="window.close()">Закрыть</button>
        </body>
        </html>
    `);
    printWindow.document.close();
}

window.printCertificate = printCertificate;