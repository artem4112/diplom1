class CharacterEngine {
    constructor() {
        this.state = { mood: 'neutral', isTalking: false, currentAnimation: null };
        this.elements = {
            leftEye: null, rightEye: null, leftPupil: null, rightPupil: null,
            mouth: null, leftBrow: null, rightBrow: null, leftArm: null, rightArm: null, body: null
        };
        this.blinkInterval = null;
        this.init();
    }

    init() {
        this.cacheElements();
        this.startBlinking();
        this.startEyeFollowing();
        this.startIdleMovement();
    }

    cacheElements() {
        this.elements.leftEye = document.getElementById('leftEye');
        this.elements.rightEye = document.getElementById('rightEye');
        this.elements.leftPupil = document.getElementById('leftPupil');
        this.elements.rightPupil = document.getElementById('rightPupil');
        this.elements.mouth = document.getElementById('characterMouth');
        this.elements.leftBrow = document.getElementById('leftBrow');
        this.elements.rightBrow = document.getElementById('rightBrow');
        this.elements.leftArm = document.getElementById('leftArm');
        this.elements.rightArm = document.getElementById('rightArm');
        this.elements.body = document.getElementById('characterBody');
    }

    startBlinking() {
        this.blinkInterval = setInterval(() => {
            const eyes = document.querySelectorAll('.eye');
            eyes.forEach(eye => {
                eye.classList.add('blink');
                setTimeout(() => eye.classList.remove('blink'), 150);
            });
        }, 3500);
    }

    startEyeFollowing() {
        document.addEventListener('mousemove', (e) => {
            if (!this.elements.leftPupil || !this.elements.rightPupil) return;
            const movePupil = (eye, pupil) => {
                if (!eye || !pupil) return;
                const rect = eye.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const angle = Math.atan2(e.clientY - cy, e.clientX - cx);
                const dist = Math.min(6, Math.hypot(e.clientX - cx, e.clientY - cy) / 18);
                pupil.style.transform = `translate(${Math.cos(angle) * dist}px, ${Math.sin(angle) * dist}px)`;
            };
            movePupil(this.elements.leftEye, this.elements.leftPupil);
            movePupil(this.elements.rightEye, this.elements.rightPupil);
        });
    }

    startIdleMovement() {
        setInterval(() => {
            if (this.state.mood === 'neutral' && !this.state.currentAnimation) {
                const rand = Math.random();
                if (rand > 0.7 && this.elements.body) {
                    this.elements.body.style.transform = `rotate(${Math.random() * 2 - 1}deg)`;
                    setTimeout(() => { if(this.elements.body) this.elements.body.style.transform = ''; }, 400);
                }
                if (rand > 0.8 && this.elements.mouth) {
                    this.elements.mouth.style.height = '14px';
                    setTimeout(() => { if(this.elements.mouth) this.elements.mouth.style.height = '8px'; }, 300);
                }
            }
        }, 5000);
    }

    setMood(mood) {
        this.state.mood = mood;
        if (this.elements.body) {
            this.elements.body.classList.remove('happy', 'thinking', 'explaining', 'celebrate');
            this.elements.body.classList.add(mood);
        }
        switch(mood) {
            case 'happy':
                if(this.elements.mouth) { this.elements.mouth.style.height = '14px'; this.elements.mouth.style.width = '36px'; this.elements.mouth.classList.remove('talking'); }
                if(this.elements.leftBrow) this.elements.leftBrow.style.transform = 'translateY(-4px) rotate(-4deg)';
                if(this.elements.rightBrow) this.elements.rightBrow.style.transform = 'translateY(-4px) rotate(4deg)';
                if(this.elements.body) this.elements.body.style.animation = 'danceAnim 0.5s ease';
                setTimeout(() => { if(this.elements.body) this.elements.body.style.animation = ''; }, 500);
                break;
            case 'thinking':
                if(this.elements.mouth) { this.elements.mouth.style.height = '4px'; this.elements.mouth.style.width = '28px'; this.elements.mouth.classList.remove('talking'); }
                if(this.elements.leftBrow) this.elements.leftBrow.style.transform = 'translateY(-6px)';
                if(this.elements.rightBrow) this.elements.rightBrow.style.transform = 'translateY(-6px)';
                if(this.elements.leftArm) this.elements.leftArm.style.transform = 'rotate(-35deg) translateY(5px)';
                break;
            case 'explaining':
                if(this.elements.mouth) this.elements.mouth.classList.add('talking');
                if(this.elements.leftBrow) this.elements.leftBrow.style.transform = 'translateY(-2px)';
                if(this.elements.rightBrow) this.elements.rightBrow.style.transform = 'translateY(-2px)';
                this.animateArms();
                break;
            case 'celebrate':
                if(this.elements.mouth) { this.elements.mouth.style.height = '16px'; this.elements.mouth.style.width = '40px'; this.elements.mouth.style.borderRadius = '50%'; this.elements.mouth.classList.remove('talking'); }
                if(this.elements.body) this.elements.body.classList.add('jump');
                if(this.elements.leftArm) this.elements.leftArm.classList.add('wave-left');
                if(this.elements.rightArm) this.elements.rightArm.classList.add('wave-right');
                setTimeout(() => {
                    if(this.elements.body) this.elements.body.classList.remove('jump');
                    if(this.elements.leftArm) this.elements.leftArm.classList.remove('wave-left');
                    if(this.elements.rightArm) this.elements.rightArm.classList.remove('wave-right');
                }, 800);
                break;
            default:
                if(this.elements.mouth) { this.elements.mouth.style.height = '8px'; this.elements.mouth.style.width = '28px'; this.elements.mouth.style.borderRadius = '0 0 20px 20px'; this.elements.mouth.classList.remove('talking'); }
                if(this.elements.leftBrow) this.elements.leftBrow.style.transform = '';
                if(this.elements.rightBrow) this.elements.rightBrow.style.transform = '';
                if(this.elements.leftArm) this.elements.leftArm.style.transform = '';
                if(this.elements.rightArm) this.elements.rightArm.style.transform = '';
        }
        if (mood !== 'explaining') {
            setTimeout(() => {
                if(this.state.mood === mood) this.setMood('neutral');
            }, 2500);
        }
    }

    animateArms() {
        let count = 0;
        const wave = () => {
            if(count >= 4) return;
            if(this.elements.leftArm) this.elements.leftArm.style.transform = 'rotate(-25deg)';
            if(this.elements.rightArm) this.elements.rightArm.style.transform = 'rotate(25deg)';
            setTimeout(() => {
                if(this.elements.leftArm) this.elements.leftArm.style.transform = 'rotate(25deg)';
                if(this.elements.rightArm) this.elements.rightArm.style.transform = 'rotate(-25deg)';
                count++;
                setTimeout(wave, 300);
            }, 200);
        };
        wave();
        setTimeout(() => {
            if(this.elements.leftArm) this.elements.leftArm.style.transform = '';
            if(this.elements.rightArm) this.elements.rightArm.style.transform = '';
        }, 1500);
    }

    playAnimation(anim) {
        this.state.currentAnimation = anim;
        switch(anim) {
            case 'dance':
                if(this.elements.body) this.elements.body.classList.add('dance');
                setTimeout(() => { if(this.elements.body) this.elements.body.classList.remove('dance'); this.state.currentAnimation = null; }, 800);
                break;
            case 'jump':
                if(this.elements.body) this.elements.body.classList.add('jump');
                setTimeout(() => { if(this.elements.body) this.elements.body.classList.remove('jump'); this.state.currentAnimation = null; }, 800);
                break;
            case 'wave':
                if(this.elements.leftArm) this.elements.leftArm.classList.add('wave-left');
                if(this.elements.rightArm) this.elements.rightArm.classList.add('wave-right');
                setTimeout(() => {
                    if(this.elements.leftArm) this.elements.leftArm.classList.remove('wave-left');
                    if(this.elements.rightArm) this.elements.rightArm.classList.remove('wave-right');
                    this.state.currentAnimation = null;
                }, 900);
                break;
            default: this.state.currentAnimation = null;
        }
    }

    startTalking() {
        if(this.state.isTalking) return;
        this.state.isTalking = true;
        if(this.elements.mouth) this.elements.mouth.classList.add('talking');
    }

    stopTalking() {
        this.state.isTalking = false;
        if(this.elements.mouth) this.elements.mouth.classList.remove('talking');
    }
}

class ProgressSystem {
    constructor() {
        this.userId = localStorage.getItem('dtk_user_id') || 'user_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('dtk_user_id', this.userId);
        this.progressData = JSON.parse(localStorage.getItem('dtk_progress_data')) || this.getDefaultProgress();
    }

    getDefaultProgress() {
        return {
            lessons: {}, tests: {}, achievements: [], totalScore: 0, lastActivity: Date.now()
        };
    }

    saveProgress() {
        this.progressData.lastActivity = Date.now();
        localStorage.setItem('dtk_progress_data', JSON.stringify(this.progressData));
    }

    updateLessonProgress(lessonId, data) {
        if (!this.progressData.lessons[lessonId]) {
            this.progressData.lessons[lessonId] = { started: false, completed: false, progress: 0, lastVisited: Date.now() };
        }
        Object.assign(this.progressData.lessons[lessonId], data, { lastVisited: Date.now() });
        this.saveProgress();
    }

    updateTestResult(testId, result) {
        if (!this.progressData.tests[testId]) {
            this.progressData.tests[testId] = { attempts: 0, bestScore: 0, lastScore: 0, history: [] };
        }
        const t = this.progressData.tests[testId];
        t.attempts++;
        t.lastScore = result.score;
        t.bestScore = Math.max(t.bestScore, result.score);
        t.history.unshift({ score: result.score, percentage: result.percentage, date: new Date().toISOString() });
        if (t.history.length > 10) t.history = t.history.slice(0, 10);
        this.progressData.totalScore += result.score;
        this.saveProgress();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    window.progressSystem = new ProgressSystem();
    if(!window.dtkCharacter) {
        const charEngine = new CharacterEngine();
        window.dtkCharacter = charEngine;
    }

    document.querySelectorAll('.eye').forEach(eye => {
        eye.addEventListener('mousemove', function (e) {
            const rect = this.getBoundingClientRect();
            const cx = rect.left + rect.width / 2;
            const cy = rect.top + rect.height / 2;
            const angle = Math.atan2(e.clientY - cy, e.clientX - cx);
            const dist = Math.min(4, Math.hypot(e.clientX - cx, e.clientY - cy) / 20);
            const pupil = this.querySelector('.pupil');
            if (pupil) {
                pupil.style.transform = `translate(${Math.cos(angle) * dist}px, ${Math.sin(angle) * dist}px)`;
            }
        });
    });

    setInterval(() => {
        document.querySelectorAll('.mouth').forEach(mouth => {
            if (!mouth.style.animation || mouth.style.animation === 'none') {
                mouth.style.height = '10px';
                setTimeout(() => { mouth.style.height = '6px'; }, 150);
            }
        });
    }, 3000);

    document.querySelectorAll('a:not([href^="#"]):not([data-bs-toggle])').forEach(link => {
        link.addEventListener('click', function (e) {
            if (this.href && this.href.includes(window.location.hostname) && !this.href.includes('logout') && !this.href.includes('delete')) {
                e.preventDefault();
                document.body.style.opacity = '0.7';
                document.body.style.transition = 'opacity 0.3s ease';
                setTimeout(() => { window.location.href = this.href; }, 300);
            }
        });
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            if (!isValid) {
                e.preventDefault();
                alert('Пожалуйста, заполните все обязательные поля');
            }
        });
    });

    const bookModal = document.getElementById('bookModal');
    if(bookModal) {
        bookModal.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;
            const title = btn.getAttribute('data-title');
            const year = btn.getAttribute('data-year');
            const genre = btn.getAttribute('data-genre');
            const lang = btn.getAttribute('data-language');
            const desc = btn.getAttribute('data-description');
            const modalTitle = bookModal.querySelector('.modal-title');
            const modalBody = bookModal.querySelector('.modal-body');
            if(modalTitle) modalTitle.textContent = title;
            if(modalBody) modalBody.innerHTML = `<p>${desc || 'Описание отсутствует'}</p><p><strong>Год:</strong> ${year || '—'}</p><p><strong>Жанр:</strong> ${genre || '—'}</p><p><strong>Язык:</strong> ${lang || '—'}</p>`;
        });
    }
});

class EnhancedMascot {
    constructor() {
        this.idleTimer = null;
        this.idleTimeout = 30000; // 30 секунд
        this.tips = {
            index: [
                "Попробуй пройти первый тест!",
                "На главной ты найдешь популярные тесты.",
                "Давай я верю в тебя"
            ],
            tests: [
                "Выбери тест и проверь свои знания!",
                "Чем больше тестов пройдёшь – тем выше твой прогресс.",
                "После теста ты получишь сертификат."
            ],
            test: [
                "Читай вопросы внимательно, не торопись.",
                "Вспоминай не волнуйся",
                "Удачи! Ты справишься!"
            ],
            result: [
                "Отличная работа!",
                "Не забудь сделать скриншот!"
            ]
        };
        this.init();
    }

    init() {
        this.bindEvents();
        this.startIdleTimer();
        // Приветствие при загрузке (на главной уже есть своё)
        if (window.location.pathname.includes('test.php')) {
            setTimeout(() => this.showMessage("Вопросов: " + document.querySelectorAll('.test-question-card').length + ". Читай внимательно!", 5000), 1000);
        } else if (window.location.pathname.includes('tests.php')) {
            setTimeout(() => this.showRandomTip('tests'), 1500);
        } else if (window.location.pathname.includes('result.php')) {
            setTimeout(() => this.showRandomTip('result'), 1500);
        }
    }

    bindEvents() {
        const character = document.getElementById('characterContainer');
        if (character) {
            character.addEventListener('click', (e) => {
                e.stopPropagation();
                this.onCharacterClick();
                this.resetIdleTimer();
            });
        }
        // Сброс таймера при любом действии пользователя
        ['mousemove', 'keydown', 'scroll', 'click'].forEach(event => {
            window.addEventListener(event, () => this.resetIdleTimer());
        });
    }

    onCharacterClick() {
        let page = 'index';
        if (window.location.pathname.includes('test.php')) page = 'test';
        else if (window.location.pathname.includes('tests.php')) page = 'tests';
        else if (window.location.pathname.includes('result.php')) page = 'result';
        this.showRandomTip(page);
        // Анимация радости
        if (window.dtkCharacter) {
            window.dtkCharacter.playAnimation('jump');
            window.dtkCharacter.setMood('happy');
        }
    }

    showRandomTip(page) {
        const tips = this.tips[page] || this.tips.index;
        const randomTip = tips[Math.floor(Math.random() * tips.length)];
        this.showMessage(randomTip);
    }

    showMessage(text, duration = 3000) {
        // Удаляем старый тост, если есть
        const oldToast = document.querySelector('.mascot-toast');
        if (oldToast) oldToast.remove();

        const toast = document.createElement('div');
        toast.className = 'mascot-toast';
        toast.innerHTML = `
            <div class="mascot-toast-inner">
                <span class="mascot-avatar">Ку</span>
                <span class="mascot-message">${text}</span>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    startIdleTimer() {
        this.idleTimer = setTimeout(() => {
            this.onIdle();
        }, this.idleTimeout);
    }

    resetIdleTimer() {
        clearTimeout(this.idleTimer);
        this.startIdleTimer();
    }

    onIdle() {
        this.showMessage("Давай проходить тест!");
        if (window.dtkCharacter) {
            window.dtkCharacter.setMood('thinking');
            window.dtkCharacter.playAnimation('wave');
        }
    }
}

// Инициализация улучшенного маскота после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    window.enhancedMascot = new EnhancedMascot();
});