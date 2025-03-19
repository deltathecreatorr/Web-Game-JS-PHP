<?php
include "connection.php";

$complexity = $_COOKIE['avatar_complexity'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['username'])) {
        $username = $data['username'];
        $table_name = "scores_" . strtolower($complexity);

       
        $check_query = "SELECT * FROM $table_name WHERE username = ?";
        $check_stmt = $connection->prepare($check_query);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            
            $row = $result->fetch_assoc();

            if ($complexity === "complex") {
                
                $current_score = $row['total_score'];
                $new_score = $data['level1'] + $data['level2'] + $data['level3'];

                if ($new_score > $current_score) {
                   
                    $update_query = "UPDATE $table_name SET level1 = ?, level2 = ?, level3 = ?, total_score = ? WHERE username = ?";
                    $stmt = $connection->prepare($update_query);
                    $stmt->bind_param("iiisi", $data['level1'], $data['level2'], $data['level3'], $new_score, $username);
                    if ($stmt->execute()) {
                        echo "Score updated successfully!";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "New score is not higher than the current score.";
                }
            } else {
      
                $current_score = $row['level1'];
                $new_score = $data['level1'];

                if ($new_score > $current_score) {
                    
                    $update_query = "UPDATE $table_name SET level1 = ? WHERE username = ?";
                    $stmt = $connection->prepare($update_query);
                    $stmt->bind_param("is", $new_score, $username);
                    if ($stmt->execute()) {
                        echo "Score updated successfully!";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "New score is not higher than the current score.";
                }
            }
        } else {
          
            if ($complexity === "complex") {
            
                $total_score = $data['level1'] + $data['level2'] + $data['level3'];
                $insert_query = "INSERT INTO $table_name (username, level1, level2, level3, total_score) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($insert_query);
                $stmt->bind_param("siiii", $username, $data['level1'], $data['level2'], $data['level3'], $total_score);
            } else {
      
                $insert_query = "INSERT INTO $table_name (username, level1) VALUES (?, ?)";
                $stmt = $connection->prepare($insert_query);
                $stmt->bind_param("si", $username, $data['level1']);
            }

            if ($stmt->execute()) {
                echo "User added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }

        $check_stmt->close();
    } else {
        echo "Username is required.";
    }
} else {
    echo "Invalid request method.";
}

$connection->close();

?>