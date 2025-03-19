<?php

$register_set = isset($_COOKIE['registered']) && $_COOKIE['registered'] == true;

if ($register_set) {
    $username = $_COOKIE['username'];
} else {
    $username = '';
}

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
    <link rel="stylesheet" type="text/css" href="../css/centered.css">
</head>


<body>
    <div class="topnav">

        <a href="index.php" name="home" style="float: left">Home</a>
       
        
        <?php if ($register_set) : ?>
            <?php echo "
                <div class='user-info'>
                    <div class='avatar-image-wrapper'>
                        <img src='$skin' class='avatar-overlayImage skin'>
                        <img src='$mouth' class='avatar-overlayImage mouth'>
                        <img src='$eyes' class='avatar-overlayImage eyes'>
                    </div>
                    <div class='username'>$username</div>
                </div>
            "; ?>
            <a href="leaderboard.php">Leaderboard</a>
            <a href="pairs.php" name="memory">Play Pairs</a>
        <?php else : ?>
            <a href="registration.php">Register</a>
            <a href="pairs.php" name="memory">Play Pairs</a>
        <?php endif; ?>

        <a href="javascript:void(0);" class="icon" onclick="navbar()"></a>
    </div>

    <script src="../js/navbar.js"></script>
</body>
</html>