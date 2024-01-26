<?php
include('includes/init.php');
include('includes/bingo-logic.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $blogId = $_POST['blog_id'];
    $content = $_POST['content'];
    $newImage = $_FILES['new_image'];

    // Check if a new image is provided
    if (!empty($newImage['name'])) {
        // Process image upload
        $uploadPath = 'uploads/' . $newImage['name'];

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($newImage['tmp_name'], $uploadPath)) {
            // Update the blog post with the new image
            $query = $connection->prepare('UPDATE blogs SET content = ?, image = ? WHERE blog_id = ?');
            $query->execute([$content, $newImage['name'], $blogId]);
        } else {
            // Handle the error if the file upload fails
            echo "Failed to move the uploaded file.";
        }
    } else {
        // Update the blog post without changing the image
        $query = $connection->prepare('UPDATE blogs SET content = ? WHERE blog_id = ?');
        $query->execute([$content, $blogId]);
    }

    // Respond to the AJAX request
    echo "Post updated successfully!";
} else {
    // If the request method is not POST, respond with an error
    http_response_code(400);
    echo "Bad Request: Invalid HTTP method.";
}
?>
