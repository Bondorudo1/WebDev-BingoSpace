<?php
include("includes/head.php")
?>
<?php
include("handlers/auth_process.php")
?>
<?php
if ($_SESSION['authorized']) {
    header('Location: index.php');
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
    include('includes/nav-new-bar.php');
    ?>


    <div class="Auth">
        <div class="container">
        <form action="#" method="post">

               
                <h2>Welcome Back</h2>
                <div class="input-group">
                    <label for="username">Email:</label>
                    <input type="email" id="email" name="email" placeholder="user@mail.com" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="123..." required>
                    <?php
if ($_SESSION['errors']['general']) {
?>
    <span class="error-message"><?php echo $_SESSION['errors']['general']; ?></span>
<?php
}
?>
                    
                </div>
                <input type="hidden" name="action" value="login">
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
    <?php
    include("./includes/footer.php");
    ?>
</body>

<style>/* Login and Register */

.container {
  width: 30rem;
  background-color: #ffffff;
  padding: 1.25rem;
  border-radius: 0.625rem;
  box-shadow: 0 0 0.625rem rgba(0, 0, 0, 0.1);
  text-align: center;
}


form {
  margin: 0 auto;
}

h2 {
  font-size: 2rem;
  margin-bottom: 1rem;
  color: #0673e8 !important;
}

.input-group {
  margin-bottom: 1rem;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

label {
  display: block;
  margin-bottom: 5px;
  color:#0673e8 !important ;
  font-weight: 500;
}

input {
  font-family: "Poppins", sans-serif;
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
  border: 1px solid gray;
  border-radius: 0.625rem;
  font-weight: 500;
  font-size: 1.5rem;
}

input[type="file"]::file-selector-button {
  max-width: 15rem;
  font-size: 1.1rem;
  background-color:#a6b1e1;
  color: #ffffff;
  font-weight: 600;
  padding: 1rem;
  border: none;
  border-radius: 0.4rem;
  cursor: pointer;
  transition: background-color 100ms ease-out;
}

input[type="file"]::file-selector-button:hover {
  background-color: #424874;
}

input:invalid,
textarea:invalid {
  border-color: #a6b1e1;
}

span.error-message {
  display: block;
  color: #e74c3c;
  font-size: 0.9rem;
  margin-top: 0.3rem;
  font-weight: 300;
}

.Auth button {
  user-select: none;
  width: 10rem;
  background-color: #a6b1e1;
  color: #ffffff;
  padding: 0.625rem 1.25rem;
  font-size: 1.2rem;
  border: none;
  border-radius: 0.4rem;
  cursor: pointer;
  transition: all 100ms ease-out;
  font-weight: 600;
}

.Auth button:hover {
  background-color:#424874;;
}

p {
  margin-top: 20px;
  color: #a6b1e1;
  font-weight: 500;
}

a {
  user-select: none;
  color:#424874;
  text-decoration: none;
  font-weight: 600;
}

a:hover {
  text-decoration: underline;
}

/* Login and Register */
</style>
</html>