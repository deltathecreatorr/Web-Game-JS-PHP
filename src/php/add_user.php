<?php

include ("connection.php");

$complexity = $_COOKIE['avatar_complexity'];

if ($complexity === "complex"){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['username']) && isset($data['level1']) && isset($data['level2']) && isset($data['level3'] )) {
            $username = $data['username'];
            $level1 = $data['level1'];
            $level2 = $data['level2'];
            $level3 = $data['level3'];
            $total_score = $level1 + $level2 + $level3;

            $table_name = "scores_" .strtolower($complexity);
            
            $stmt = $connection -> prepare("INSERT INTO $table_name (username, level1, level2, level3, total_score) VALUES (?, ?, ?, ?, ?)");

            $stmt -> bind_param("siiii", $username, $level1, $level2, $level3, $total_score);

            if ($stmt -> execute()) {
                echo "User added";
            } else {
                echo "Error: " . $stmt -> error;
            }
            $stmt -> close();
        }
        
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['username']) && isset($data['level1'])) {
            $username = $data['username'];
            $level1 = $data['level1'];
            $table_name = "scores_" .strtolower($complexity);
            $stmt = $connection -> prepare("INSERT INTO $table_name (username, level1) VALUES (?, ?)");
            $stmt -> bind_param("si", $username, $level1);

            if ($stmt -> execute()) {
                echo "User added";
            } else {
                echo "Error: " . $stmt -> error;
            }
            $stmt -> close();
        }
    }
}

$connection -> close();

?>