<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $complexity = $_POST['avatar_complexity'];
    $registered = false;

    $error = " ";
    if (!ctype_alpha($username)) {
        echo "<script>alert('Invalid characters present!!')</script>";
    } elseif (empty($username)){
        echo "<script>alert('Cannot be empty!')</script>";
    } else {
        $registered = true;
        $_SESSION['username'] = $username;
        $_SESSION['avatar_complexity'] = $complexity;
        $_SESSION['registered'] = $registered;

        setcookie('username', $username, time() + (86400*30), "/");
        setcookie('avatar_complexity', $complexity, time() + (86400*30), "/");
        setcookie('registered', $registered, time() + (86400*30), "/");

        header('Location: pairs.php');
        exit;
    }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="../css/page.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../css/centered.css">
    <link rel="stylesheet" type="text/css" href="../css/registration_page/form.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/navbar.php'; ?>

    <div class="main">
        <h1 style="color: white; padding: 0px 20px; padding-top: 20px; font-weight: bold;">Registration</h1>
        <form action="registration.php" method="POST">
            <!-- Username -->
            <div class="mb-3 registration_form">
                <label class="form-label">Enter your username.</label>
                <input type="text" class="form-control" name="username" required></input>
            </div>

            <br>
            <!-- Selector -->
            <div class="centered">
                <label for="avatar_complexity">Avatar Complexity:</label>
                <select class="form-select-padding-3" id="avatar_complexity" name="avatar_complexity" required>

                    <option value="simple">Simple</option>
                    <option value="medium">Medium</option>
                    <option value="complex">Complex</option>

                </select>
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 110px;">Register</button>
            </div>
        </form>
    </div>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>