<?php
include('includes/init.php');
include('includes/bingo-logic.php');
include('includes/head.php');

// hello
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['blog_id'])) {
    // Fetch the blog post details
    $blogId = $_GET['blog_id'];
    $query = $connection->prepare('SELECT * FROM blogs WHERE blog_id = ?');
    $query->execute([$blogId]);
    $blogPost = $query->fetch(PDO::FETCH_ASSOC);

    // Display the form for editing
    ?>
    <body>
        <!-- Add your HTML structure for the edit form -->
        <form method="post" action="update_post.php" enctype="multipart/form-data">
            <input type="hidden" name="blog_id" value="<?= $blogPost['blog_id'] ?>">
            
            <!-- Add form fields for editing, e.g., title, content, image -->
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?= $blogPost['title'] ?>" required>

            <label for="content">Content:</label>
            <textarea name="content" required><?= $blogPost['content'] ?></textarea>

            <label for="new_image">New Image:</label>
            <input type="file" name="new_image" accept="image/*">

            <button type="submit" name="updateButton">Update Post</button>
        </form>
    </body>
    <?php
}
?>
