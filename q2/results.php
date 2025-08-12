<?php
session_start();

if (!$_SESSION['resultUploaded']) {
    $_SESSION['scorePercent'] = round(($_SESSION['score'] / $_SESSION['maxScore']) * 100, 1);
    require_once "includes/library.php";
    $pdo = connectdb();
    $stmt = $pdo->prepare('INSERT INTO 3430_a1q2_scores (name, score, play_percent, played_at) VALUES (?, ?, ?, NOW())');
    $stmt->execute([$_SESSION['name'], $_SESSION['score'], $_SESSION['scorePercent']]);
    $_SESSION['resultUploaded'] = true;
}

if (isset($_POST['start'])) {
    session_destroy();
    header("Location:start.php");
    exit();
}

if (isset($_POST['leaderboard'])) {
    header("Location:leaderboard.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <title>Results</title>
</head>

<body>
    <h1>Word Scramble Game: Session Management and Databases</h1>
    <h2>Results</h2>
    <div>
        <strong>Total Score:</strong> <?= $_SESSION['score'] ?>
    </div>
    <div>
        <strong>Max Possible Score:</strong> <?= $_SESSION['maxScore'] ?>
    </div>
    <div>
        <strong>Summary of Guesses:</strong>
        <ul>
            <?php foreach ($_SESSION['correct'] as $answerRound => $answerResult) : ?>
                <li>
                    Round <?= $answerRound ?>: <span class="<?= $answerResult ? "correct" : "error" ?>">
                        <?= $answerResult ? "correct" : "incorrect" ?>
                    </span>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <form method="POST">
        <button id="start" type="submit" name="start">Play Again</button>
        <button id="leaderboard" type="submit" name="leaderboard">Top Scores</button>
    </form>
</body>

</html>