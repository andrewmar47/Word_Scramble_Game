<?php
session_start();

$guess = $_POST['guess'] ?? "";
$errors = array();
$correct = false;

if (isset($_POST['submit'])) {
    if ($guess == "") {
        $errors['guess'] = true;
    }

    if (empty($errors)) {
        if ($_SESSION['currentWord']['difficulty'] == "easy") {
            $_SESSION['maxScore']++;
        } else if ($_SESSION['currentWord']['difficulty'] == "medium") {
            $_SESSION['maxScore'] += 2;
        } else if ($_SESSION['currentWord']['difficulty'] == "hard") {
            $_SESSION['maxScore'] += 3;
        }

        if ($guess == $_SESSION['currentWord']['word']) {
            if ($_SESSION['currentWord']['difficulty'] == "easy") {
                $_SESSION['score']++;
            } else if ($_SESSION['currentWord']['difficulty'] == "medium") {
                $_SESSION['score'] += 2;
            } else if ($_SESSION['currentWord']['difficulty'] == "hard") {
                $_SESSION['score'] += 3;
            }
            $_SESSION['correct'][$_SESSION['currentRound']] = true;
        } else {
            $_SESSION['correct'][$_SESSION['currentRound']] = false;
        }

        $_SESSION['currentRound']++;
        if ($_SESSION['currentRound'] > $_SESSION['rounds']) {
            header("Location:results.php");
            exit();
        }

        $_SESSION['usedWords'][] = $_SESSION['currentWord'];
        $_SESSION['availableWords'] = array_filter($_SESSION['allWords'], function ($wordData) {
            return !in_array($wordData['word'], $_SESSION['usedWords']);
        });
        // array_rand() found at https://www.w3schools.com/php/func_array_rand.asp#:~:text=The%20array_rand()%20function%20returns,return%20more%20than%20one%20key.
        $_SESSION['currentWord'] = $_SESSION['availableWords'][array_rand($_SESSION['availableWords'])];
        // str_split found at https://www.w3schools.com/php/func_string_str_split.asp
        $letters = str_split($_SESSION['currentWord']['word']);
        shuffle($letters);
        $_SESSION['shuffledWord'] = implode("", $letters);
    }
} else {
    $_SESSION['availableWords'] = array_filter($_SESSION['allWords'], function ($wordData) {
        return !in_array($wordData['word'], $_SESSION['usedWords']);
    });
    // array_rand() found at https://www.w3schools.com/php/func_array_rand.asp#:~:text=The%20array_rand()%20function%20returns,return%20more%20than%20one%20key.
    if (empty($_SESSION['shuffledWord'])) {
        $_SESSION['currentWord'] = $_SESSION['availableWords'][array_rand($_SESSION['availableWords'])];
        // str_split found at https://www.w3schools.com/php/func_string_str_split.asp
        $letters = str_split($_SESSION['currentWord']['word']);
        shuffle($letters);
        $_SESSION['shuffledWord'] = implode("", $letters);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <title>Play</title>
</head>

<body>
    <h1>Word Scramble Game: Session Management and Databases</h1>
    <h2>Play</h2>

    <div>
        <strong><?= $_SESSION['shuffledWord'] ?></strong>
    </div>

    <form method="POST" id="guess-box">
        <label for="guess">Enter Guess:</label>
        <input id="guess" type="text" name="guess">
        <span class="error <?= !isset($errors['name']) ? 'hidden' : '' ?>">
            You must enter a guess.
        </span>
        <button id="submit" type="submit" name="submit">Submit</button>
    </form>
    <div>
        Current Round: <?= $_SESSION['currentRound'] ?>
    </div>
    <div>
        Total Rounds: <?= $_SESSION['rounds'] ?>
    </div>
    <div>
        Current score: <?= $_SESSION['score'] ?>
    </div>
</body>

</html>