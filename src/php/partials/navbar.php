<?php

$register_set = isset($_COOKIE['registered']) && $_COOKIE['registered'] == true;

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
        <?php else : ?>
            <a href="registration.php">Register</a>
        <?php endif; ?>

        <a href="javascript:void(0);" class="icon" onclick="navbar()"></a>
    </div>

    <script src="../js/navbar.js"></script>
</body>
</html>