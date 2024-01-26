<?php

include('includes/init.php');
include('includes/bingo-logic.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blogId = $_POST['blog_id'];

    // Perform the deletion query
    $query = $connection->prepare('DELETE FROM blogs WHERE blog_id = ?');
    $query->execute([$blogId]);

    // You can add additional logic, such as deleting associated images if needed

    echo 'Post deleted successfully';
} else {
    // Handle invalid requests
    echo 'Invalid request';
}
?>
