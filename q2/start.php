<?php 
session_start();
require_once "includes/library.php";
$_SESSION['name'] = $_POST['name'] ?? "";
$_SESSION['rounds'] = $_POST['rounds'] ?? "";
$_SESSION['maxScore'] = 0;
$_SESSION['score'] = 0;
$_SESSION['scorePercent'] = null;
$_SESSION['currentRound'] = 1;
$pdo = connectdb();
$_SESSION['allWords'] = $pdo->query("SELECT word, difficulty FROM 3430_a1q2_words")->fetchAll();
$_SESSION['usedWords'] = array();
$_SESSION['availableWords'] = $_SESSION['allWords'];
$_SESSION['currentWord'] = null;
$_SESSION['shuffledWord'] = null;
$_SESSION['resultUploaded'] = false;
$errors = array();

if(isset($_POST['submit'])) {
    if($_SESSION['name'] == "") {
        $errors['name'] = true;
    }

    if($_SESSION['rounds'] == "") {
        $errors['rounds'] = true;
    }

    if(empty($errors)) {
        header("Location:play.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css" >
    <title>Question 2</title>
</head>

<body>
    <h1>Word Scramble Game: Session Management and Databases</h1>
    <h2>Start</h2>
    <form method="POST">
        <div id="name-container">
            <label for="name">Enter your Name:</label>
            <input id="name" type="text" name="name" />
            <span class="error <?= !isset($errors['name']) ? 'hidden' : '' ?>">
                Please enter a name.
            </span>
        </div>
        <div id="rounds-container">
            <label>Select Number of Rounds:</label>
            <div>
                <input id="rounds3" type="radio" name="rounds" value= "3"/>
                <label for="rounds3">3 Rounds</label>
            </div>
            <div>
                <input id="rounds5" type="radio" name="rounds" value= "5"/>
                <label for="rounds5">5 Rounds</label>
            </div>
            <div>
                <input id="rounds10" type="radio" name="rounds" value= "10"/>
                <label for="rounds10">10 Rounds</label>
            </div>
            <span class="error <?= !isset($errors['rounds']) ? 'hidden' : '' ?>">
                Please select the number of rounds.
            </span>
        </div>
        <button id="submit" type="submit" name="submit">Submit</button>
    </form>
</body>

</html>