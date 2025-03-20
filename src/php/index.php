<?php

// start session and get cookie to see if user has registered
session_start();
$register_set = isset($_COOKIE['registered']) && $_COOKIE['registered'] === true;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Landing Page</title>
    <link rel="stylesheet" type="text/css" href="../css/page.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/index_page/index_page.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/navbar.php'; ?>
    <div class="main">
        <div class="index_page">
            <!-- Change to play game button if the user has registered -->
            <h1> Welcome To Pairs </h1>
            <?php if ($register_set) : ?>
                <a type="button" href="pairs.php" class="btn btn-primary btn-lg">Click here to play</a>
            <?php else : ?>
                <p> You're not using a registered session? 
                    <a href="registration.php">Register now</a>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>