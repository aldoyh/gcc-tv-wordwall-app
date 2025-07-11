<?php
// Simple PHP API for Q&A and leaderboard using SQLite3
header('Content-Type: application/json');

$db = new SQLite3(__DIR__ . '/game.db');

// Create tables if not exist
$db->exec('CREATE TABLE IF NOT EXISTS questions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    game_id INTEGER,
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
$db->exec('CREATE TABLE IF NOT EXISTS games (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    template TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'create_game':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare('INSERT INTO games (title, description, template) VALUES (?, ?, ?)');
        $stmt->bindValue(1, $input['title'], SQLITE3_TEXT);
        $stmt->bindValue(2, $input['description'], SQLITE3_TEXT);
        $stmt->bindValue(3, $input['template'], SQLITE3_TEXT);
        $stmt->execute();
        $game_id = $db->lastInsertRowID();
        echo json_encode(['status' => 'ok', 'game_id' => $game_id]);
        break;
    case 'get_game':
        $game_id = $_GET['id'] ?? 0;
        $stmt = $db->prepare('SELECT * FROM games WHERE id = ?');
        $stmt->bindValue(1, $game_id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $game = $result->fetchArray(SQLITE3_ASSOC);
        echo json_encode($game);
        break;
    case 'update_game_template':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare('UPDATE games SET template = ? WHERE id = ?');
        $stmt->bindValue(1, $input['template'], SQLITE3_TEXT);
        $stmt->bindValue(2, $input['game_id'], SQLITE3_INTEGER);
        $stmt->execute();
        echo json_encode(['status' => 'ok']);
        break;
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
        $stmt = $db->prepare('INSERT INTO questions (game_id, text, options, correct_option) VALUES (?, ?, ?, ?)');
        $stmt->bindValue(1, $input['game_id'], SQLITE3_INTEGER);
        $stmt->bindValue(2, $input['text'], SQLITE3_TEXT);
        $stmt->bindValue(3, json_encode($input['options']), SQLITE3_TEXT);
        $stmt->bindValue(4, $input['correct_option'], SQLITE3_INTEGER);
        $stmt->execute();
        echo json_encode(['status' => 'ok']);
        break;
    case 'delete_question':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare('DELETE FROM questions WHERE id = ?');
        $stmt->bindValue(1, $input['question_id'], SQLITE3_INTEGER);
        $stmt->execute();
        echo json_encode(['status' => 'ok']);
        break;
    case 'update_questions':
        $input = json_decode(file_get_contents('php://input'), true);
        foreach ($input as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $id = str_replace('question_', '', $key);
                $stmt = $db->prepare('UPDATE questions SET text = ?, options = ?, correct_option = ? WHERE id = ?');
                $stmt->bindValue(1, $value, SQLITE3_TEXT);
                $stmt->bindValue(2, json_encode(explode(',', $input['options_' . $id])), SQLITE3_TEXT);
                $stmt->bindValue(3, $input['correct_option_' . $id], SQLITE3_INTEGER);
                $stmt->bindValue(4, $id, SQLITE3_INTEGER);
                $stmt->execute();
            }
        }
        echo json_encode(['status' => 'ok']);
        break;
    case 'get_questions':
        $game_id = $_GET['game_id'] ?? 0;
        $res = $db->query('SELECT * FROM questions WHERE game_id = ' . intval($game_id));
        $questions = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $row['options'] = json_decode($row['options']);
            $questions[] = $row;
        }
        echo json_encode($questions);
        break;
}
