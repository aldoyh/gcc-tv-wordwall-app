<?php
// Simple PHP API for Q&A and leaderboard using SQLite3
header('Content-Type: application/json');

$db = new SQLite3(__DIR__ . '/game.db');

// Create tables if not exist
$db->exec('CREATE TABLE IF NOT EXISTS questions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    text TEXT NOT NULL,
    options TEXT NOT NULL,
    correct_option INTEGER NOT NULL
)');
$db->exec('CREATE TABLE IF NOT EXISTS answers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    question_id INTEGER,
    player_name TEXT,
    answer INTEGER,
    response_time REAL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');
$db->exec('CREATE TABLE IF NOT EXISTS leaderboard (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    player_name TEXT,
    score INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add_answer':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare('INSERT INTO answers (question_id, player_name, answer, response_time) VALUES (?, ?, ?, ?)');
        $stmt->bindValue(1, $input['question_id'], SQLITE3_INTEGER);
        $stmt->bindValue(2, $input['player_name'], SQLITE3_TEXT);
        $stmt->bindValue(3, $input['answer'], SQLITE3_INTEGER);
        $stmt->bindValue(4, $input['response_time'], SQLITE3_FLOAT);
        $stmt->execute();
        echo json_encode(['status' => 'ok']);
        break;
    case 'get_answers':
        $question_id = $_GET['question_id'] ?? 0;
        $res = $db->query('SELECT * FROM answers WHERE question_id = ' . intval($question_id));
        $answers = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $answers[] = $row;
        }
        echo json_encode($answers);
        break;
    case 'add_leaderboard':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare('INSERT INTO leaderboard (player_name, score) VALUES (?, ?)');
        $stmt->bindValue(1, $input['player_name'], SQLITE3_TEXT);
        $stmt->bindValue(2, $input['score'], SQLITE3_INTEGER);
        $stmt->execute();
        echo json_encode(['status' => 'ok']);
        break;
    case 'get_leaderboard':
        $res = $db->query('SELECT * FROM leaderboard ORDER BY score DESC LIMIT 10');
        $leaders = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $leaders[] = $row;
        }
        echo json_encode($leaders);
        break;
    case 'add_question':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare('INSERT INTO questions (text, options, correct_option) VALUES (?, ?, ?)');
        $stmt->bindValue(1, $input['text'], SQLITE3_TEXT);
        $stmt->bindValue(2, json_encode($input['options']), SQLITE3_TEXT);
        $stmt->bindValue(3, $input['correct_option'], SQLITE3_INTEGER);
        $stmt->execute();
        echo json_encode(['status' => 'ok']);
        break;
    case 'get_questions':
    default:
        $res = $db->query('SELECT * FROM questions');
        $questions = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $row['options'] = json_decode($row['options']);
            $questions[] = $row;
        }
        echo json_encode($questions);
        break;
}
