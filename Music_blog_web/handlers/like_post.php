<?php
include('../includes/init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['blog_id'])) {
    // Sanitize input
    $blogId = filter_input(INPUT_POST, 'blog_id', FILTER_SANITIZE_NUMBER_INT);

    // Assuming you have the user ID stored in $_SESSION['id']
    $userId = $_SESSION['id'];

    // Check if the user has already liked the post (using a cookie)
    $cookieName = 'liked_blog_' . $userId . '_' . $blogId;

    if (!isset($_COOKIE[$cookieName])) {
        // User has not liked the post yet, so add a like
        $updateQuery = $connection->prepare('UPDATE blogs SET likes_count = likes_count + 1 WHERE blog_id = :blog_id');
        $updateQuery->bindParam(':blog_id', $blogId, PDO::PARAM_INT);
        $updateQuery->execute();

        // Set a cookie to mark that the user has liked this post
        setcookie($cookieName, '1', time() + (365 * 24 * 60 * 60), '/');

        // Return the updated likes_count and like status
        $selectQuery = $connection->prepare('SELECT likes_count, 1 as like_status FROM blogs WHERE blog_id = :blog_id');
        $selectQuery->bindParam(':blog_id', $blogId, PDO::PARAM_INT);
        $selectQuery->execute();
        $result = $selectQuery->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        // User has already liked this post, so remove the like
        $updateQuery = $connection->prepare('UPDATE blogs SET likes_count = likes_count - 1 WHERE blog_id = :blog_id');
        $updateQuery->bindParam(':blog_id', $blogId, PDO::PARAM_INT);
        $updateQuery->execute();

        // Delete the cookie to mark that the user has unliked this post
        setcookie($cookieName, '', time() - 3600, '/');

        // Return the updated likes_count and like status
        $selectQuery = $connection->prepare('SELECT likes_count, 0 as like_status FROM blogs WHERE blog_id = :blog_id');
        $selectQuery->bindParam(':blog_id', $blogId, PDO::PARAM_INT);
        $selectQuery->execute();
        $result = $selectQuery->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
