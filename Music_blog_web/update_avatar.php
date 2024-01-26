<?php
include('includes/init.php');
include('includes/bingo-logic.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($userId) {
        try {
            // Handle file upload
            $uploadDir = 'uploads/';
            $avatarFile = $uploadDir . basename($_FILES['avatar']['name']);
            echo $avatarFile;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatarFile)) {
                // Update the user's profile picture in the database
                $connection->beginTransaction();

                $query = $connection->prepare('UPDATE users SET profilePicture = :avatar WHERE id = :userId');
                $query->bindParam(':avatar', $_FILES['avatar']['name']);
                $query->bindParam(':userId', $userId, PDO::PARAM_INT);
                $query->execute();
                $connection->commit();

                // Redirect back to the main page or wherever you want
                header('Location: index.php');
                exit;
            } else {
                echo "Failed to upload avatar.";
            }
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
