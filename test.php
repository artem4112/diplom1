<?php
session_start();

$questions = [
    ['question' => 'Год рождения П.Н. Тобурокова?', 'answers' => ['1913', '1914', '1915'], 'correct' => 0],
    ['question' => 'Народный поэт какой республики?', 'answers' => ['Якутии', 'Бурятии', 'Татарстана'], 'correct' => 0],
    ['question' => 'Кем был Тобуроков?', 'answers' => ['Писатель и поэт', 'Художник', 'Музыкант'], 'correct' => 0],
    ['question' => 'Одна из его известных книг?', 'answers' => ['На берегах Вилюя', 'Анна Каренина', 'Мастер и Маргарита'], 'correct' => 0],
    ['question' => 'Тема его творчества?', 'answers' => ['Природа Якутии', 'Городская жизнь', 'Космос'], 'correct' => 0],
    ['question' => 'Книга "Долина белых..."?', 'answers' => ['Журавлей', 'Медведей', 'Оленей'], 'correct' => 0],
    ['question' => 'Сколько лет со дня рождения в 2024?', 'answers' => ['110 лет', '100 лет', '90 лет'], 'correct' => 0],
    ['question' => 'Жанр "Цветы на снегу"?', 'answers' => ['Поэзия', 'Детектив', 'Фантастика'], 'correct' => 0]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $user_answers = [];
    
    foreach ($questions as $index => $question) {
        $answer_key = 'q' . $index;
        if (isset($_POST[$answer_key])) {
            $user_answer = intval($_POST[$answer_key]);
            $user_answers[$index] = $user_answer;
            
            if ($user_answer === $question['correct']) {
                $score++;
            }
        } else {
            $user_answers[$index] = -1;
        }
    }
    
    $_SESSION['test_results'] = [
        'score' => $score,
        'total' => count($questions),
        'user_answers' => $user_answers,
        'questions' => $questions,
        'percentage' => round(($score / count($questions)) * 100)
    ];
    
    header('Location: result.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест: Тобуроков - ДТК Центр чтения</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="test-header">
            <a href="lesson.php" class="back-home">
                Назад к уроку
            </a>
            <h1>Тест: Тобуроков юбиляр</h1>
            <p>8 вопросов о Тобурокове</p>
        </header>

<!-- ... остальной код без изменений до вопросов ... -->

<div class="test-instructions">
    <h3>Внимание, внимание!</h3>
    <p>Тест-викторина про Тобурокова! 8 вопросов — как 8 глав приключенческой книги. Выбирай самый интересный ответ!</p>
</div>

<form action="test.php" method="POST" id="testForm">
    <?php 
    $updatedQuestions = [
        [
            'question' => 'В каком году родился Петр Тобуроков, наш юбиляр?',
            'answers' => ['1913 год', '1914 год — именно этот!', '1915 год'],
            'correct' => 1
        ],
        [
            'question' => 'Почётное звание Тобурокова — народный поэт...?',
            'answers' => ['Якутии — правильно!', 'Бурятии', 'Татарстана'],
            'correct' => 0
        ],
        [
            'question' => 'Кем был Тобуроков, кроме писателя?',
            'answers' => ['Прекрасным поэтом — да!', 'Художником', 'Музыкантом'],
            'correct' => 0
        ],
        [
            'question' => 'Какая книга точно принадлежит перу Тобурокова?',
            'answers' => ['На берегах Вилюя — его знаменитая книга!', 'Анна Каренина', 'Мастер и Маргарита'],
            'correct' => 0
        ],
        [
            'question' => 'О чем чаще всего писал Тобуроков?',
            'answers' => ['О природе Якутии — её красоте!', 'О городской жизни', 'О космосе'],
            'correct' => 0
        ],
        [
            'question' => 'Закончи название: "Долина белых..."?',
            'answers' => ['Журавлей — красиво же!', 'Медведей', 'Оленей'],
            'correct' => 0
        ],
        [
            'question' => 'Сколько лет исполняется Тобурокову в 2024 году?',
            'answers' => ['110 лет — юбилей!', '100 лет', '90 лет'],
            'correct' => 0
        ],
        [
            'question' => 'К какому жанру относится "Цветы на снегу"?',
            'answers' => ['Поэзия — лирическая и красивая!', 'Детектив', 'Фантастика'],
            'correct' => 0
        ]
    ];
    
    foreach ($updatedQuestions as $index => $question): 
    ?>
    <div class="test-question">
        <div class="question-number">Вопрос <?php echo $index + 1; ?> из 8</div>
        <h3 class="question-title"><?php echo $question['question']; ?></h3>
        
        <div class="answer-options">
            <?php foreach ($question['answers'] as $answer_index => $answer): ?>
            <div class="answer-item">
                <input type="radio" 
                       name="q<?php echo $index; ?>" 
                       id="q<?php echo $index; ?>_a<?php echo $answer_index; ?>"
                       value="<?php echo $answer_index; ?>"
                       required>
                <label for="q<?php echo $index; ?>_a<?php echo $answer_index; ?>">
                    <span class="option-letter"><?php echo chr(65 + $answer_index); ?></span>
                    <span class="option-text"><?php echo $answer; ?></span>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
    
    <div class="test-submit-area">
        <button type="submit" class="submit-test-btn pulse">
            Готово! Посмотрим результат!
        </button>
        <p class="test-note">После отправки ты увидишь, какой ты эксперт по Тобурокову!</p>
    </div>
</form>

<!-- ... остальной код без изменений ... -->
    </div>
</body>
</html>