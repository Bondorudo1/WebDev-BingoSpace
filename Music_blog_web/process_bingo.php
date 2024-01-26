<?php
include('includes/init.php');
include('includes/bingo-logic.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['userId'];

    // Insert a new record into the 'user_bingo' table
    $query = $connection->prepare('INSERT INTO user_bingo (user_id, template_id, date) VALUES (?, ?, CURRENT_DATE())');
    
    try {
        // Execute the query
        $query->execute([$userId, $templateId]);
        echo 'Bingo obtained successfully!';
    } catch (PDOException $e) {
        // Handle any database errors
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // If the form is not submitted, redirect to the main page or show an error message
    echo 'Invalid request!';
}
?>
