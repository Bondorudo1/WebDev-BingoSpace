<?php
// Get the current page URL
$current_page = basename($_SERVER['PHP_SELF']);

?>

<header class="header_section">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg custom_nav-container">
     
      <a class="navbar-brand" href="index.php">
        <span>
          BingoSpace
        </span>
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""> </span>
      </button>

      <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
        <!-- Center-aligned items using text-center class -->
        <ul class="navbar-nav mx-auto">
          <li class="nav-item <?= ($current_page == 'index.php' || $current_page == 'index.html') ? 'active' : '' ?>">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item <?= ($current_page == 'blog.php') ? 'active' : '' ?>">
            <a class="nav-link" href="blog.php">Blog</a>
          </li>
          <li class="nav-item <?= ($current_page == 'bingo.php') ? 'active' : '' ?>">
            <a class="nav-link" href="bingo.php">Bingo Quests</a>
          </li>
        </ul>
      </div>

      <div class="user-info">
        <?php
        if ($_SESSION['authorized']) {
          try{  
            $query = $connection->prepare('SELECT completed_bingo FROM users WHERE id = ?');
            $query->execute([$userId]);
            $completedBingosCount = $query->fetchColumn();
            $query = $connection->prepare('SELECT email FROM users WHERE id = ?');
            $query->execute([$userId]);
            $userEmail = $query->fetchColumn();
        ?>
         <span class="completed-bingos" style="color:white; display:flex; flex-direction:column; align-items:center;">
        Completed Bingos<span class="number_bingo"><?= $completedBingosCount ?></span>
      </span>
          <div class="dropdown">
            <img src="uploads/<?= $profilePicture ?>" alt="Profile Picture" class="profile-picture" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="dropdown-menu" style="left:-135px;" aria-labelledby="userDropdown">
            <div class="dropdown-item">
                <p class="text-primary"><?= $userEmail ?></p>
          </div>
              <div class="dropdown-divider"></div>
              <button class="update-avatar"  data-toggle="modal" data-target="#updateAvatarModal">Update Avatar</button>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <span class="text-primary">Logout</span>
              </a>
            </div>
          </div>
          <?php
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  } else {
  ?>
          <!-- Display login link if the user is not authorized -->
          <a class="login" style="color:white; padding-right:0.8em;" href="login.php">Login</a>
        <?php
        }
        ?>
      </div>
    </nav>
  </div>
</header>

<!-- Update Avatar Modal -->
<div class="modal fade" id="updateAvatarModal" tabindex="-1" role="dialog" aria-labelledby="updateAvatarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateAvatarModalLabel">Update Avatar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="update_avatar.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="avatar">Choose a new avatar:</label>
            <input type="file" class="form-control-file" id="avatar" name="avatar" accept="image/*">
          </div>
          <button type="submit" class="btn btn-primary">Upload Avatar</button>
        </form>
      </div>
    </div>
  </div>
</div>
