<?php include('includes/init.php') ?>
<?php include('includes/bingo-logic.php');?>

<?php
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
        ?>

  
    <section class="welcome_section">
    <div class="welcome_text">
  <h1 class="title">Welcome to BingoSpace - Your Bingo Adventure Awaits!</h1>
  <h2 class="after_title">Explore and share your bingo experiences with the BingoSpace community. Dive into our blogs, discover exciting bingo quests, and connect with fellow enthusiasts. Start building your unique bingo space today and embark on a journey filled with fun and challenges.</h2>
</div>

    <img src="images/music_player.png" >
    </section>
    <!-- end header section -->

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

  <!-- jQery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- custom js -->
  <script type="text/javascript" src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->

</body>

</html>