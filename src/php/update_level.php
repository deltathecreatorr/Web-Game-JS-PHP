<?php

if (isset($_POST['current_level'])) {
    $_SESSION['current_level'] = intval($_POST['current_level']);
    echo "Session updated: Level " . $_SESSION['current_level'];
} else {
    echo "Invalid request.";
}
?>