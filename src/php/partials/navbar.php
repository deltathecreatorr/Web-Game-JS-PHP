<?php

$register_set = isset($_COOKIE['registered']) && $_COOKIE['registered'] == true;

if (isset($_COOKIE['avatar_config'])) {
    $avatar_config = json_decode($_COOKIE['avatar_config'], true);

    $skin = $avatar_config['skin'];
    $mouth = $avatar_config['mouth'];
    $eyes = $avatar_config['eyes'];

}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="../css/page.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar/navbar.css">
</head>


<body>
    <div class="topnav">

        <a href="index.php" name="home" style="float: left">Home</a>
        <a href="pairs.php" name="memory">Play Pairs</a>
        
        <?php if ($register_set) : ?>
            <a href="leaderboard.php">Leaderboard</a>
            <?php echo "
                <div class='avatar-image-wrapper'>
                    <img src='$skin' class='avatar-overlayImage skin'>
                    <img src='$mouth' class='avatar-overlayImage mouth'>
                    <img src='$eyes' class='avatar-overlayImage eyes'>
                </div>
            ";  ?>
        <?php else : ?>
            <a href="registration.php">Register</a>
        <?php endif; ?>

        <a href="javascript:void(0);" class="icon" onclick="navbar()"></a>
    </div>

    <script src="../js/navbar.js"></script>
</body>
</html>