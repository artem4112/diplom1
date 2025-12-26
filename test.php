<?php
session_start();

$questions = [
    ['question' => 'Что развивает регулярное чтение книг?', 'answers' => ['Только память', 'Воображение, память и словарный запас', 'Только грамотность'], 'correct' => 1],
    ['question' => 'Сколько минут в день рекомендуется читать детям?', 'answers' => ['5-10 минут', '20-30 минут', 'Более 1 часа'], 'correct' => 1],
    ['question' => 'Как книги помогают понимать других людей?', 'answers' => ['Не помогают', 'Показывают разные характеры и ситуации', 'Только если это книги по психологии'], 'correct' => 1],
    ['question' => 'Что такое "буккроссинг"?', 'answers' => ['Переплет книг', 'Обмен книгами между читателями', 'Новый жанр литературы'], 'correct' => 1],
    ['question' => 'Как выбрать интересную книгу?', 'answers' => ['Только по обложке', 'По аннотации, отзывам и рекомендациям', 'По толщине книги'], 'correct' => 1],
    ['question' => 'Что дает чтение перед сном?', 'answers' => ['Мешает спать', 'Помогает расслабиться и уснуть', 'Не влияет на сон'], 'correct' => 1],
    ['question' => 'Какой жанр книг рассказывает о вымышленных мирах?', 'answers' => ['Детектив', 'Фантастика', 'Биография'], 'correct' => 1],
    ['question' => 'Почему важно читать вслух?', 'answers' => ['Чтобы все слышали', 'Для развития дикции и выразительности', 'Не важно, можно читать про себя'], 'correct' => 1],
    ['question' => 'Что делать, если слово в книге непонятно?', 'answers' => ['Пропустить его', 'Посмотреть в словаре', 'Придумать свое значение'], 'correct' => 1],
    ['question' => 'Как часто стоит посещать библиотеку?', 'answers' => ['Раз в год', '1-2 раза в месяц', 'Только по необходимости'], 'correct' => 1]
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
    <title>Тест знаний - ДТК Центр чтения</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="test-header">
            <a href="lesson.php" class="back-home">
                Вернуться к уроку
            </a>
            <h1>Тест знаний</h1>
            <p>Проверь, что ты запомнил из урока!</p>
        </header>

        <div class="test-instructions">
            <h3>Инструкция:</h3>
            <p>1. Прочитай каждый вопрос внимательно</p>
            <p>2. Выбери один правильный ответ из трех вариантов</p>
            <p>3. Всего 10 вопросов</p>
            <p>4. После завершения ты получишь сертификат!</p>
        </div>

        <form action="test.php" method="POST" id="testForm" class="main-content">
            <?php foreach ($questions as $index => $question): ?>
            <div class="question-block">
                <div class="question-counter">
                    Вопрос <?php echo $index + 1; ?> из 10
                </div>
                
                <h3 class="question-text">
                    <?php echo $question['question']; ?>
                </h3>
                
                <div class="answers-container">
                    <?php foreach ($question['answers'] as $answer_index => $answer): ?>
                    <div class="answer-option">
                        <input type="radio" 
                               name="q<?php echo $index; ?>" 
                               id="q<?php echo $index; ?>_a<?php echo $answer_index; ?>"
                               value="<?php echo $answer_index; ?>"
                               required>
                        <label for="q<?php echo $index; ?>_a<?php echo $answer_index; ?>">
                            <?php echo chr(65 + $answer_index); ?>. <?php echo $answer; ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            
            <div class="test-submit">
                <button type="submit" class="submit-test-btn">
                    Завершить тест и увидеть результат
                </button>
            </div>
        </form>
    </div>
</body>
</html>