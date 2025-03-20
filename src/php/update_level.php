<?php

// script to update the current_level

// check if the current_level is in the $_POST
if (isset($_POST['current_level'])) {
    // if set, update the session variable and then convert the value to an integer
    $_SESSION['current_level'] = intval($_POST['current_level']);
    echo "Session updated: Level " . $_SESSION['current_level'];
} else {
    echo "Invalid request.";
}
?>