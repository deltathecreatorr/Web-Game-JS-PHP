<?php

$register_set = isset($_COOKIE['registered']) && $_COOKIE['registered'] === true;
$complexity = $_COOKIE ['avatar_complexity'];

$simple_image_list = array(
    array('../images/emoji_assets/eyes/laughing.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/yellow.png'),
    array('../images/emoji_assets/eyes/closed.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/yellow.png'),
    array('../images/emoji_assets/eyes/winking.png"','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/yellow.png')
);

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

    <div class="game-page">
        <div class="centered">
            <div class="start-game-area">
                <?php if ($register_set) : ?>
                    <button id="remove-button" type="button" class="btn btn-warning">Start the game</button>
                    <?php if ($complexity === 'simple') : ?>
                        <div id="game-square" class="hidden">
                            <div class="scoreboard">
                                <p>
                                    Score: 
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
                    <?php else: ?>
                    <?php endif; ?>
                <?php else : ?>
                    <?php header('Location: registration.php'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>