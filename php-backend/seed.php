<?php
$db = new SQLite3(__DIR__ . '/game.db');

$questions = [
    [
        'text' => 'What is the capital of France?',
        'options' => ['Paris', 'London', 'Berlin', 'Madrid'],
        'correct_option' => 0,
    ],
    [
        'text' => 'What is the largest planet in our solar system?',
        'options' => ['Mars', 'Jupiter', 'Venus', 'Saturn'],
        'correct_option' => 1,
    ],
    [
        'text' => 'What is the chemical symbol for water?',
        'options' => ['H2O', 'CO2', 'O2', 'NaCl'],
        'correct_option' => 0,
    ],
];

foreach ($questions as $question) {
    $stmt = $db->prepare('INSERT INTO questions (text, options, correct_option) VALUES (?, ?, ?)');
    $stmt->bindValue(1, $question['text'], SQLITE3_TEXT);
    $stmt->bindValue(2, json_encode($question['options']), SQLITE3_TEXT);
    $stmt->bindValue(3, $question['correct_option'], SQLITE3_INTEGER);
    $stmt->execute();
}

echo "Database seeded successfully.\n";

