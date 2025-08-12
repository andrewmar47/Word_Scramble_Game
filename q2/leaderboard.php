<?php
session_start();
require_once "includes/library.php";
$pdo = connectdb();
$results = $pdo->query("SELECT name, score, play_percent, played_at FROM 3430_a1q2_scores ORDER BY score DESC LIMIT 10")->fetchAll();

if (isset($_POST['start'])) {
    session_destroy();
    header("Location:start.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <title>Leaderboard</title>
</head>

<body>
    <h1>Word Scramble Game: Session Management and Databases</h1>
    <h2>Leaderboard</h2>

    <table>
        <thead>
            <tr>
                <th>Player Name</th>
                <th>Score</th>
                <th>Score Percentage</th>
                <th>Date Played</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result) : ?>
                <tr>
                    <td><?= $result['name'] ?></td>
                    <td><?= $result['score'] ?></td>
                    <td><?= $result['play_percent'] ?></td>
                    <td><?= $result['played_at'] ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <!-- I know this was not in the instructions but I figured there should be a way to get back to the start page -->
    <form method="POST" id="leaderboard-button">
        <button id="start" type="submit" name="start">Play Again</button>
    </form>
</body>

</html>