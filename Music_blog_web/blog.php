<?php
include('includes/init.php');
include('includes/bingo-logic.php');
include('includes/head.php');
?>
<?php
include("handlers/update_post.php")
?>
<?php
if (!$_SESSION['authorized']) {
    header('Location: ' . $BASE_URL . 'login.php');
    exit();
}
?>
<body>
    <div class="hero_area">
        <div class="hero_bg_box">
            <div class="bg_img_box">
                <img src="images/hero-bg.png" alt="">
            </div>
        </div>

        <?php
        include('includes/nav-bar.php');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ?>

        <!-- Display blog posts feed -->
        <div class="blog-feed-container">
            <?php
            // Fetch blog posts from the database with user information
            $query = $connection->query('SELECT b.*, u.email,u.profilePicture FROM blogs b
                                    JOIN users u ON b.user_id = u.id
                                    ORDER BY b.post_date DESC');
            $blogPosts = $query->fetchAll(PDO::FETCH_ASSOC);

            // Display each blog post
            foreach ($blogPosts as $blogPost) :
            ?>
            <div class="blog-post" data-blog-id="<?= $blogPost['blog_id'] ?>">
            <div class="author-info" style="display:flex; flex-direction:row;align-items:center;justigy-content:center;">
    <img src="uploads/<?= $blogPost['profilePicture'] ?>" alt="Profile Picture" class="profile-picture" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <p style="margin-left:1em; color: #5a9ee7 !important;"><?= $blogPost['email'] ?> </p>
</div>

                    <div class="blog-image">
                        <img src="uploads/<?= $blogPost['image'] ?>" alt="Blog Image">
                    </div>
                    <div class="blog-content">
                        <h3 class="bingo-blog" style="font-size:25px" >BINGO:    <?= $blogPost['title'] ?></h3>
                        <p style="font-size:22px"><?= $blogPost['content'] ?></p>
                      
                        
    <!-- Like button -->
<div class="like-button" data-blog-id="<?= $blogPost['blog_id'] ?>">
<input type="hidden" id="user-id-input" value="<?= $_SESSION['id'] ?>">
    <svg class="heart-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" id="heart">
        <path d="M45.281 25.915c4.949-5.004 4.949-13.146 0-18.15A12.556 12.556 0 0 0 36.292 4h-.001c-3.396 0-6.59 1.337-8.991 3.765L25 10.09l-2.3-2.325A12.56 12.56 0 0 0 13.709 4a12.56 12.56 0 0 0-8.99 3.765c-4.949 5.004-4.949 13.146 0 18.15L25 46.422l20.281-20.507zM6.141 9.171A10.575 10.575 0 0 1 13.709 6c2.858 0 5.547 1.126 7.569 3.171L25 12.935l3.722-3.764A10.576 10.576 0 0 1 36.291 6c2.858 0 5.546 1.126 7.568 3.171 4.183 4.229 4.183 11.109 0 15.338L25 43.578 6.141 24.509c-4.183-4.229-4.183-11.11 0-15.338z"></path>
    </svg>
</div>
<span class="likes-count"><?= $blogPost['likes_count'] ?> likes</span>

                        <!-- Edit button (displayed only if the logged-in user is the author) -->
                        <?php if ($user1 && $blogPost['user_id'] == $user1['id']) : ?>
                            <button class="edit-button" data-blog-id="<?= $blogPost['blog_id'] ?>">Edit</button>
                        <?php endif; ?>
                    </div>
                    <!-- Edit form (displayed only if the edit mode is active for this post) -->
                    <div class="edit-form" data-blog-id="<?= $blogPost['blog_id'] ?>" style="display: none;">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="blog_id" value="<?= $blogPost['blog_id'] ?>">      
                            <label for="content">Content:</label>
                            <textarea name="content" required><?= $blogPost['content'] ?></textarea>
                            <label for="new_image">New Image:</label>
                            <input type="file" name="new_image" accept="image/*">
                            <button type="button" class="update-button">Update Post</button>
                            <button class="delete-button delete-button-red" data-blog-id="<?= $blogPost['blog_id'] ?>">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- footer section -->
    <section class="footer_section">
        <div class="container">
            <p>
                &copy; <span id="displayYear"></span> All Rights Reserved By
                <a href="https://html.design/">BingoSpace</a>
            </p>
        </div>
    </section>
    <!-- footer section -->

    <!-- jQuery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- Bootstrap.js -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- Owl Carousel -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- Custom.js -->
    <script type="text/javascript" src="js/custom.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
    <!-- End Google Map -->

    <!-- Add your custom script for in-place editing -->
    
    <script src="js/blog-handling.js"></script>
   
    <!-- End custom script -->
</body>

<!-- Add your custom styles here -->
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .hero_area {
        position: relative;
        background-color: #150B63;
    }

    .hero_bg_box {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .bg_img_box img {
        width: 100%;
        height: auto;
    }

    .blog-feed-container {
        max-width: 800px;
        margin: 20px auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .blog-post {
        width: 100%;
        margin-bottom: 20px;
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        background-color:#f4fdff;
    }

    .blog-post:hover {
        transform: scale(1.05);
    }

    .blog-image img {
        width: 100%;
        border-radius: 8px;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .blog-content h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .blog-content p {
        color: #495057;
    }

    .user-info {
        margin-top: 10px;
        font-size: 14px;
        color: #6c757d;
    }

    .footer_section {
        background-color: #f4f4f4;
        padding: 20px 0;
        text-align: center;
    }

    .delete-button {
        background-color: #dc3545;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .delete-button:hover {
        background-color: #c82333;
    }

    .delete-button-red {
        float: right;
    }
    .like-button {
    /* Your existing styles */
    display: inline-flex;
    align-items: center;
}

.like-button {
    /* Your existing styles for the button */
    display: inline-flex;
    align-items: center;
    border: none;
    background: none;
    cursor: pointer;
    padding: 0;
}

.like-button:hover .heart-icon {
    fill: #0056b3; /* Change color on hover */
}

.like-button.liked .heart-icon {
    fill: red; /* Change color when liked */
}

.heart-icon {
    width: 2em;
    height: 2em;
    margin-right: 0.5em;
    fill: #000; /* Default color of the heart */
    transition: fill 0.3s ease-in-out;
    /* Add any additional styling for the heart icon here */
}

/* Optionally, you can hide the button text if needed */
.like-button span {
    display: none;
}



</style>

</html>
