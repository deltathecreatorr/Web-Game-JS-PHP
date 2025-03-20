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
    <link rel="stylesheet" type="text/css" href="../css/registration_page/avatar_complexity.css">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
			integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			crossorigin="anonymous">
    </script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<?php

require 'connection.php';

// When user registers, a post request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // get the contents of the form
    $username = $_POST['username'];
    $complexity = $_POST['avatar_complexity'];
    $registered = false;

    // if username has invalid characters
    if (!ctype_alpha($username)) {
        echo "<script>
            $(document).ready(function() {
                $('#username-error').text('Invalid characters present!!').show();
            });
        </script>";
    // if username is empty
    } elseif (empty($username)){
        echo "<script>
            $(document).ready(function() {
                $('#username-error').text('Username cannot be empty!').show();
            });
        </script>";
    // if the username can be added
    } else {
        // get table in leaderboard_db based on complexity
        $table_name = "scores_" . strtolower($complexity);
        // Preparing an SQL query
        $stmt = $connection->prepare("SELECT username FROM $table_name WHERE username = ?");
        // The username is binded to the prepare statement
        $stmt -> bind_param("s", $username);
        // Execure query and store result
        $stmt -> execute();
        $stmt -> store_result();

        // checking if the username exists in the database
        if ($stmt -> num_rows > 0) {
            echo "<script>
                $(document).ready(function() {
                    $('#username-error').text('Username already exists!').show();
                });
            </script>";
        } else {
            // If the username doesn't exists, create the user 
            $registered = true;
            $_SESSION['username'] = $username;
            $_SESSION['avatar_complexity'] = $complexity;
            $_SESSION['registered'] = $registered;

            // setting cookies so that user can come back and logs in automatically, if page closes
            setcookie('username', $username, time() + (86400*30), "/");
            setcookie('avatar_complexity', $complexity, time() + (86400*30), "/");
            setcookie('registered', $registered, time() + (86400*30), "/");

            // once user registers, direct to game page
            header('Location: pairs.php');
            exit;
        }

        $stmt -> close();

    }

    $connection -> close();

}

$simple_avatar_list = array(
    '../images/emoji_assets/eyes/laughing.png','../images/emoji_assets/mouth/smiling.png','../images/emoji_assets/skin/red.png'
);

$medium_avatar_list = array(
    array('../images/emoji_assets/eyes/laughing.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/yellow.png'),
    array('../images/emoji_assets/eyes/closed.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/green.png'),
    array('../images/emoji_assets/eyes/winking.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/skin/red.png')
);

$complex_avatar_list = array(
    array('../images/emoji_assets/eyes/closed.png','../images/emoji_assets/eyes/laughing.png','../images/emoji_assets/eyes/long.png','../images/emoji_assets/eyes/normal.png','../images/emoji_assets/eyes/rolling.png','../images/emoji_assets/eyes/winking.png'),
    array('../images/emoji_assets/mouth/open.png','../images/emoji_assets/mouth/sad.png','../images/emoji_assets/mouth/smiling.png','../images/emoji_assets/mouth/straight.png','../images/emoji_assets/mouth/surprise.png','../images/emoji_assets/mouth/teeth.png'),
    array('../images/emoji_assets/skin/green.png','../images/emoji_assets/skin/red.png','../images/emoji_assets/skin/yellow.png')
);

?>

<body>
    <?php include 'partials/navbar.php'; ?>
    <!-- Pass arrays for each avatar to use in javascript -->
    <script> const simple_avatar_list = <?php echo json_encode($simple_avatar_list); ?> </script>
    <script> const medium_avatar_list = <?php echo json_encode($medium_avatar_list); ?> </script>
    <script> const complex_avatar_list = <?php echo json_encode($complex_avatar_list); ?> </script>
    <script src="../js/avatar.js"></script>
    <div class="main">
        <h1 style="color: white; padding: 0px 20px; padding-top: 20px; font-weight: bold;">Registration</h1>
        <form id="registration_form" action="registration.php" method="POST">
            <div id="username_form" class="mb-3 registration_form">
                <label class="form-label">Enter your username.</label>
                <input type="text" class="form-control" name="username" required></input>
                <div id="username-error" class="error-message"></div>
            </div>

            <br>
  
            <div class="centered">
                <label for="avatar_complexity">Avatar Complexity:</label>
                <select class="form-select-padding-3" id="avatar_complexity" name="avatar_complexity" required>

                    <option value="simple">Simple</option>
                    <option value="medium">Medium</option>
                    <option value="complex">Complex</option>

                </select>
               
                <div class="simple_choice avatar_section">
                    <div class="centered">
                        <h1> Default Avatar </h1>
                        <div class="image-wrapper">
                            <img src="<?php echo $simple_avatar_list[2]; ?>" class="overlayImage skin">
                            <img src="<?php echo $simple_avatar_list[1]; ?>" class="overlayImage mouth">
                            <img src="<?php echo $simple_avatar_list[0]; ?>" class="overlayImage eyes">
                        </div>
                    </div>
                </div>
               
                <div class="medium_choice avatar_section"></div>
                
                <div class="complex_choice avatar_section"></div>


                <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 110px;">Register</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>