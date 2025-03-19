<?php

$register_set = isset($_COOKIE['registered']) && $_COOKIE['registered'] === true;
$complexity = $_COOKIE['avatar_complexity'];
$username = $_COOKIE['username'];

include 'connection.php';

$tablename = "scores_" . strtolower($complexity);


if ($complexity === "complex") {
    $query = "SELECT total_score FROM $tablename WHERE username = '$username'";
} else {
    $query = "SELECT level1 FROM $tablename WHERE username = '$username'";
}

$best_score = 0;

if ($result && $result -> num_rows > 0) {
    $row = $result -> fetch_assoc();
    if ($complexity === "complex") {
        $best_score = $row['total_score'];
    } else {
        $best_score = $row['level1'];
    }
} else {
    $best_score = 0;
}

$simple_image_list = array(
    array('../images/emoji_assets/eyes/laughing.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/yellow.png'),
    array('../images/emoji_assets/eyes/closed.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/yellow.png'),
    array('../images/emoji_assets/eyes/winking.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/yellow.png')
);

$medium_image_list = array(
    array('../images/emoji_assets/eyes/closed.png','../images/emoji_assets/eyes/laughing.png','../images/emoji_assets/eyes/long.png','../images/emoji_assets/eyes/normal.png','../images/emoji_assets/eyes/rolling.png','../images/emoji_assets/eyes/winking.png'),
    array('../images/emoji_assets/mouth/open.png','../images/emoji_assets/mouth/sad.png','../images/emoji_assets/mouth/smiling.png','../images/emoji_assets/mouth/straight.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/mouth/teeth.png'),
    array('../images/emoji_assets/skin/green.png','../images/emoji_assets/skin/red.png','../images/emoji_assets/skin/yellow.png')
);

$medium_random_list = array(
    array(),
    array(),
    array(),
    array(),
    array(),
);

$_SESSION['current_level'] = 1;
$complex_card_amount = array(3, 4, 5);
$complex_card_match = array(2, 3, 4);

function complex_create_emojis($amount, $match, $image_list){

    $random_list = array();

    for ($j = 0; $j < count($amount); $j++){

        $random_list[$j] = array();

        for ($k = 0; $k < $amount[$j]; $k++){
            $emoji_eyes = $image_list[0][rand(0,sizeof($image_list[0])-1)];
            $emoji_mouth = $image_list[1][rand(0,sizeof($image_list[1]) -1)];
            $emoji_skin = $image_list[2][rand(0,sizeof($image_list[2]) -1)];

            $emoji_set = array($emoji_eyes, $emoji_mouth, $emoji_skin);
            
            for ($l = 0; $l < $match[$j]; $l++){
                $random_list[$j][] = $emoji_set;
            }
        }
    }

    return $random_list;
}

$complex_random_list = complex_create_emojis($complex_card_amount, $complex_card_match, $medium_image_list);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pairs Game</title>
    <link rel="stylesheet" type="text/css" href="../css/page.css">
    <link rel="stylesheet" type="text/css" href="../css/centered.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/pairs_page/game_page.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
			integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			crossorigin="anonymous">
    </script>
    <script src="../js/game_logic.js"></script>
</head>

<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="main">
        <div class="game-page">
            <div class="centered">
                <div class="start-game-area">
                    <?php if ($register_set) : ?>
                        <?php echo "<script> var username ='" .$username."';</script>"; ?>
                        <?php echo "<script> var bestscore ='" .$best_score."';</script>"; ?>
                        <button id="remove-button" type="button" class="btn btn-warning">Start the game</button>
                        <?php echo "<script> var complexity ='" .$complexity."';</script>"; ?>
                        <?php if ($complexity === 'simple') : ?>
                            <div id="game-square" class="hidden">
                                <div class="scoreboard">
                                    <p id="score">
                                        Score 
                                    </p>
                                </div>
                                <div id="game-board">
                                    <?php for ($x = 0; $x <= 1; $x++) : ?>
                                        <?php foreach ($simple_image_list as $preset) : ?>
                                            <div class="game-card-container">
                                                <div class="game-card">
                                                    <div class="front">
                                                        <img src="../images/q_mark.png">
                                                    </div>
                                                    <div class="back">
                                                        <div class="image-wrapper">
                                                            <img src="<?php echo $preset[2]; ?>" class="overlayImage skin">
                                                            <img src="<?php echo $preset[1]; ?>" class="overlayImage mouth">
                                                            <img src="<?php echo $preset[0]; ?>" class="overlayImage eyes">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endfor;?>
                                </div>
                            </div>
                        <?php elseif ($complexity === 'medium'): ?>
                            <div id="game-square" class="hidden">
                                    <?php for ($z = 0; $z <= 4; $z++) : ?>
                                        <?php $emoji_eyes = $medium_image_list[0][rand(0,sizeof($medium_image_list[0])-1)]  ?>
                                        <?php $emoji_mouth = $medium_image_list[1][rand(0,sizeof($medium_image_list[1]) -1)]  ?> 
                                        <?php $emoji_skin = $medium_image_list[2][rand(0,sizeof($medium_image_list[2]) -1)]  ?>
                                        <?php $medium_random_list[$z][0] = $emoji_eyes ?>
                                        <?php $medium_random_list[$z][1] = $emoji_mouth ?> 
                                        <?php $medium_random_list[$z][2] = $emoji_skin ?>
                                    <?php endfor; ?>
                                <div class="scoreboard">
                                    <p id="score">
                                        Score:
                                    </p>
                                    <p id="time">
                                        Time:
                                    </p>
                                </div>
                                <div id="game-board">    
                                    <?php for ($y = 0; $y <= 1; $y++) : ?>
                                        <?php foreach ($medium_random_list as $image) : ?>
                                            <div class="game-card-container">
                                                <div class="game-card">
                                                    <div class="front">
                                                        <img src="../images/q_mark.png">
                                                    </div>
                                                    <div class="back">
                                                        <div class="image-wrapper">
                                                            <img src="<?php echo $image[2]; ?>" class="overlayImage skin">
                                                            <img src="<?php echo $image[1]; ?>" class="overlayImage mouth">
                                                            <img src="<?php echo $image[0]; ?>" class="overlayImage eyes">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php echo "<script> var current_level = " . $_SESSION['current_level'] . ";</script>";  ?>
                            <?php echo "<script> var complex_random_array = " . json_encode($complex_random_list) . ";</script>"; ?>
                            <?php echo "<script> var complex_match_array = " . json_encode($complex_card_match) . ";</script>"; ?>
                            <div id="game-square" class="hidden">
                                <div class="scoreboard">
                                    <p id="score">
                                        Score: 
                                    </p>
                                    <p id="time">
                                        Time:
                                    </p>
                                </div>
                                <div id="game-board">
                                    <?php foreach ($complex_random_list[$_SESSION['current_level'] - 1] as $image) : ?>
                                        <div class="game-card-container">
                                            <div class="game-card">
                                                <div class="front">
                                                    <img src="../images/q_mark.png">
                                                </div>
                                                <div class="back">
                                                    <div class="image-wrapper">
                                                        <img src="<?php echo $image[2]; ?>" class="overlayImage skin">
                                                        <img src="<?php echo $image[1]; ?>" class="overlayImage mouth">
                                                        <img src="<?php echo $image[0]; ?>" class="overlayImage eyes">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php header('Location: registration.php'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>