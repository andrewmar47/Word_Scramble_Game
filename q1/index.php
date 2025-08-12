<?php

$sentence = $_POST['sentence'] ?? "";
$word1 = $_POST['word1'] ?? "";
$word2 = $_POST['word2'] ?? "";
$errors = array();
$countWord2 = "";
$numUniqueWords = '';
$longest = '';
$sortedSentence = '';
$groups = array();

if(isset($_POST['submit'])) {
    if ($sentence == "") {
        $errors['no-sentence'] = true;
    }
    // Regex implementation found at https://www.w3schools.com/php/php_regex.asp
    if(!preg_match('/^\w+$/', $word1) || $word1 == "") {
        $errors['no-word1'] = true;
    }
    if(!preg_match('/^\w+$/', $word2) || $word2 == "") {
        $errors['no-word2'] = true;
    }

    if (empty($errors)) {
        // Part 1
        $sentence = strtolower($sentence);
        $word1 = strtolower($word1);
        $word2 = strtolower($word2);

        $sentence = trim($sentence);
        $word1 = trim($word1);
        $word2 = trim($word2);

        // str_replace found at https://www.w3schools.com/php/func_string_str_replace.asp
        $sentence = str_replace($word1, $word2, $sentence);
        
        $countWord2 = substr_count($sentence, $word2);
        // Part 2
        $sentenceWords = explode(" ", $sentence);
        $sentenceWords = array_unique($sentenceWords);
        sort($sentenceWords);
        $numUniqueWords = sizeof($sentenceWords);
        foreach ($sentenceWords as $word) {
            // strlen() found at https://www.w3schools.com/php/func_string_strlen.asp
            if (strlen($word) > strlen($longest)) {
                $longest = $word;
            }
        }
        $sortedSentence = implode(" ", $sentenceWords);
        foreach ($sentenceWords as $word) {
            $firstLetter = substr($word, 0, 1);
            $groups[$firstLetter][] = $word;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question 1</title>
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
    <h1>Question 1: Form Processing with PHP String and Array Functions</h1>

    <form method="POST">
        <div id="sentence-container">
            <label for="sentence">Enter a Sentence:</label>
            <input id="sentence" type="text" name="sentence" value="<?= $sentence ?>" />
            <span class="error <?= !isset($errors['no-sentence']) ? 'hidden' : '' ?>">
                Please enter a sentence.
            </span>
        </div>
        <div id="word1-container">
            <label for="word1">Enter a Word:</label>
            <input id="word1" type="text" name="word1" value="<?= $word1 ?>" />
            <span class="error <?= !isset($errors['no-word1']) ? 'hidden' : '' ?>">
                Please enter a word.
            </span>
        </div>
        <div id="word2-container">
            <label for="word2">Enter a 2nd Word:</label>
            <input id="word2" type="text" name="word2" value="<?= $word2 ?>" />
            <span class="error <?= !isset($errors['no-word2']) ? 'hidden' : '' ?>">
                Please enter a word.
            </span>
        </div>
        <button id="submit" type="submit" name="submit">Submit</button>
    </form>
    <h2>Results</h2>
    <div>New sentence: <?= $sentence ?></div>
    <div>Number of times 2nd word appears: <span class="<?= !empty($errors) ? 'hidden' : '' ?>"><?= $countWord2 ?></span></div>
    <div>Total number of unique words: <?= $numUniqueWords ?></div>
    <div>Longest word in sentence: <?= $longest ?></div>
    <div>Sorted Array: <?= $sortedSentence ?></div>
    <div>Grouped Words:  
        <ul>
            <?php foreach($groups as $group => $words) : ?>
                <li><?= $group ?>
                    <ul>
                        <?php foreach($words as $word) : ?>
                            <li><?= $word ?></li>
                        <?php endforeach ?>
                    </ul>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</body>

</html>