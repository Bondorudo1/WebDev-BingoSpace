<?php
include('includes/init.php');
include('includes/bingo-logic.php');
include('includes/head.php');

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

        <?php if  (!$_SESSION['authorized']) : ?>
            <!-- Show the "Register" button only when the user is not logged in -->
            <div class="holder-login">
                <a href="login.php" class="login-but">Login</a>
            </div>
        <?php else: ?>
            <!-- Show the random bingos only when the user is logged in -->
            <?php if (!$completedBingoId) : ?>
                <?php if (isset($randomBingos)) : ?>
                    <div class="bingo-container-wrapper">
                        <?php foreach ($randomBingos as $index => $randomBingo) : ?>
                            <div class="bingo-container">
                                <form method="POST" class="form-bingo" enctype="multipart/form-data">
                                    <!-- Display selected image at the top -->
                                    <div class="bingo-image">
            <input  type="file" class="input-file" name="image<?= $index ?>" id="fileInput<?= $index ?>" accept="image/*" onchange="handleImageChange(this, <?= $index ?>)" required>
            <label for="fileInput<?= $index ?>" class="label-image"  ><svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#7d8197" stroke="#7d8197"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M768 810.7c-23.6 0-42.7-19.1-42.7-42.7s19.1-42.7 42.7-42.7c94.1 0 170.7-76.6 170.7-170.7 0-89.6-70.1-164.3-159.5-170.1L754 383l-10.7-22.7c-42.2-89.3-133-147-231.3-147s-189.1 57.7-231.3 147L270 383l-25.1 1.6c-89.5 5.8-159.5 80.5-159.5 170.1 0 94.1 76.6 170.7 170.7 170.7 23.6 0 42.7 19.1 42.7 42.7s-19.1 42.7-42.7 42.7c-141.2 0-256-114.8-256-256 0-126.1 92.5-232.5 214.7-252.4C274.8 195.7 388.9 128 512 128s237.2 67.7 297.3 174.2C931.5 322.1 1024 428.6 1024 554.7c0 141.1-114.8 256-256 256z" fill="#0673e8"></path><path d="M640 789.3c-10.9 0-21.8-4.2-30.2-12.5L512 679l-97.8 97.8c-16.6 16.7-43.7 16.7-60.3 0-16.7-16.7-16.7-43.7 0-60.3l128-128c16.6-16.7 43.7-16.7 60.3 0l128 128c16.7 16.7 16.7 43.7 0 60.3-8.4 8.4-19.3 12.5-30.2 12.5z" fill="#0673e85F6379"></path><path d="M512 960c-23.6 0-42.7-19.1-42.7-42.7V618.7c0-23.6 19.1-42.7 42.7-42.7s42.7 19.1 42.7 42.7v298.7c0 23.5-19.1 42.6-42.7 42.6z" fill="#0673e85F6379"></path></g></svg>Upload a file</label>
            
            <!-- Display selected image -->

            <img class="image-attached" id="image-preview<?= $index ?>" src="#" alt="Image Preview" style="display: none; max-width: 100%; max-height: 300px;">
            <div class="close-button" id="close-button<?= $index ?>" onclick="removeImage(<?= $index ?>)"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#0673e8"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Close_Square"> <path id="Vector" d="M9 9L11.9999 11.9999M11.9999 11.9999L14.9999 14.9999M11.9999 11.9999L9 14.9999M11.9999 11.9999L14.9999 9M4 16.8002V7.2002C4 6.08009 4 5.51962 4.21799 5.0918C4.40973 4.71547 4.71547 4.40973 5.0918 4.21799C5.51962 4 6.08009 4 7.2002 4H16.8002C17.9203 4 18.4801 4 18.9079 4.21799C19.2842 4.40973 19.5905 4.71547 19.7822 5.0918C20.0002 5.51962 20.0002 6.07967 20.0002 7.19978V16.7998C20.0002 17.9199 20.0002 18.48 19.7822 18.9078C19.5905 19.2841 19.2842 19.5905 18.9079 19.7822C18.4805 20 17.9215 20 16.8036 20H7.19691C6.07899 20 5.5192 20 5.0918 19.7822C4.71547 19.5905 4.40973 19.2842 4.21799 18.9079C4 18.4801 4 17.9203 4 16.8002Z" stroke="#0673e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg></div>

            <!-- Close button to remove attached image -->
                        
        </div>
                                    <div class="bingo-content">
                                        <p class="bingo-title"><?= $randomBingo['description']; ?></p>
                                        <div class="bingo-form-row">
                                            <textarea class="form-control" name="comment<?= $index ?>"  cols="30" rows="7" placeholder="Add your comment here"></textarea>
                                            <button class="post-button" type="submit" name="postButton<?= $index ?>">Post Bingo</button>
                                        </div>
                                        <!-- Include hidden input fields to detect "Get your bingos" button click and template ID -->
                                        <input type="hidden" name="getBingoButton" value="1">
                                        <input type="hidden" name="templateId<?= $index ?>" value="<?= $randomBingo['template_id'] ?>">
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

    </div>
  <!-- ... (your existing HTML code) ... -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    var closeButtons = document.querySelectorAll('.close-button');
    closeButtons.forEach(function(button) {
        button.style.display = 'none';
    });
});

function handleImageChange(input, index) {
    var imagePreview = document.getElementById('image-preview' + index);
    var closeButton = document.getElementById('close-button' + index);
    var label = document.querySelector('[for=fileInput' + index + ']');

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            input.style.display = 'none';
            closeButton.style.display = 'block';
            label.classList.add('file-attached');
            label.style.display = 'none'; // Hide the label when a file is attached
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(index) {
    var imagePreview = document.getElementById('image-preview' + index);
    var fileInput = document.getElementsByName('image' + index)[0];
    var closeButton = document.getElementById('close-button' + index);
    var label = document.querySelector('[for=fileInput' + index + ']');

    if (imagePreview.src !== '') {
        imagePreview.src = '';
        imagePreview.style.display = 'none';
        fileInput.value = '';
        fileInput.style.display = 'inline-block';
        closeButton.style.display = 'none';
        label.classList.remove('file-attached');
        label.style.display = 'inline-block'; // Show the label when the file is removed
    }
}
</script>

<!-- ... (your existing HTML code) ... -->




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

</body>

</html>
