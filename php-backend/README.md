# PHP Backend API

This is a simple PHP API for a Q&A game.

## Endpoints

*   `GET /api.php?action=get_questions`

    Fetches all questions from the database.

*   `POST /api.php?action=add_question`

    Adds a new question to the database. Expects a JSON body with the following properties:

    *   `text` (string): The question text.
    *   `options` (array of strings): The possible answers.
    *   `correct_option` (integer): The index of the correct answer in the `options` array.

*   `POST /api.php?action=add_answer`

    Adds a new answer to the database. Expects a JSON body with the following properties:

    *   `question_id` (integer): The ID of the question being answered.
    *   `player_name` (string): The name of the player.
    *   `answer` (integer): The index of the selected answer.
    *   `response_time` (float): The time it took the player to answer the question.

*   `GET /api.php?action=get_answers&question_id=<id>`

    Fetches all answers for a given question.

*   `POST /api.php?action=add_leaderboard`

    Adds a new entry to the leaderboard. Expects a JSON body with the following properties:

    *   `player_name` (string): The name of the player.
    *   `score` (integer): The player's score.

*   `GET /api.php?action=get_leaderboard`

    Fetches the top 10 entries from the leaderboard.
