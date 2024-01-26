<?php

$userId = $_SESSION['id'];
$user1 = null;
$completedBingoId = null;
$randomBingoIds = [];

function isValidFile($filePath)
{
        $allowedImageExteniton = ["png","jpg","jpeg","webp"];

        $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedImageExteniton)) {
            return true;
        }

    // No match found, delete the file
    unlink($filePath);
    return false;
}

if ($userId) {
    try {
        $query = $connection->prepare('SELECT profilePicture FROM users WHERE id = :userId');
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();
        $profilePicture = $query->fetchColumn();

        if ($profilePicture) {
            "uploads/" . $profilePicture;
        } else {
            $defaultPicture = "users_pictures/default/user.png";
            $profilePicture = $defaultPicture;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


if ($userId) {
    try {
        $query = $connection->prepare('SELECT * FROM users WHERE id = ?');
        $query->execute([$userId]);
        $user1 = $query->fetch();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$randomBingos = [];

if (!isset($_SESSION['randomBingoIds']) || empty($_SESSION['randomBingoIds'])) {
    generateRandomBingos();
} else {
    $randomBingoIds = $_SESSION['randomBingoIds'];

    foreach ($randomBingoIds as $randomBingoId) {
        try {
            $query = $connection->prepare('SELECT * FROM bingo_templates WHERE template_id = ?');
            $query->execute([$randomBingoId]);
            $randomBingo = $query->fetch(PDO::FETCH_ASSOC);
            $randomBingos[] = $randomBingo;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bingoCompleted = false;

    foreach ($randomBingos as $index => $randomBingo) {
        $comment = $_POST['comment' . $index];
        $image = isset($_FILES['image' . $index]) ? $_FILES['image' . $index] : null;
        $templateId = $_POST['templateId' . $index];
        $postButton = $_POST['postButton' . $index];

        if (isset($postButton) && $templateId == $randomBingo['template_id']) {
            try {
                $bingoId = $templateId;

                $query = $connection->prepare('SELECT description FROM bingo_templates WHERE template_id = ?');
                $query->execute([$bingoId]);
                $bingoDescription = $query->fetchColumn();

                $query = $connection->prepare('INSERT INTO blogs (user_id, title, content, image) VALUES (?, ?, ?, ?)');
                $query->execute([$userId, $bingoDescription, $comment, $image['name']]);
                $blogId = $connection->lastInsertId();
                
                

        

                $query = $connection->prepare('UPDATE users SET completed_bingo = completed_bingo + 1 WHERE id = ?');
                $query->execute([$userId]);

                $completedBingosQuery = $connection->prepare('SELECT completed_bingo FROM users WHERE id = ?');
                $completedBingosQuery->execute([$userId]);
                $completedBingosCount = $completedBingosQuery->fetchColumn();

                $_SESSION['completedBingosCount'] = $completedBingosCount;

                if (!empty($image['name'])) {
                    $uploadPath = UPLOAD_DIR . $image['name'];

                    if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                        // File successfully uploaded
                    } else {
                        echo "Failed to move the uploaded file.";
                    }

                    if (isValidFile( $uploadPath)) {
                        
                    }

                }

                $randomBingos[$index] = generateSingleRandomBingo();
                $_SESSION['randomBingoIds'][$index] = $randomBingos[$index]['template_id'];

                setcookie('selected_bingo_' . $index, $randomBingos[$index]['template_id'], time() + (86400 * 30), "/");

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }

    if ($bingoCompleted) {
        header('Location: bingo.php');
        exit;
    }
}

function generateSingleRandomBingo() {
    global $connection;

    $query = $connection->query('SELECT * FROM bingo_templates ORDER BY RAND() LIMIT 1');
    return $query->fetch(PDO::FETCH_ASSOC);
}

function generateRandomBingos() {
    global $connection, $randomBingos;
    $userCookiePrefix = 'user_' . $_SESSION['id'] . '_selected_bingo_';

for ($index = 0; $index < 3; $index++) {
    $cookieName = $userCookiePrefix . $index;

    if (isset($_COOKIE[$cookieName])) {
        $selectedBingoIds[] = $_COOKIE[$cookieName];
    }
}

     if (!empty($selectedBingoIds)) {
        $placeholders = implode(', ', array_fill(0, count($selectedBingoIds), '?'));
        $query = $connection->prepare("SELECT * FROM bingo_templates WHERE template_id IN ($placeholders)");
        $query->execute($selectedBingoIds);
        $randomBingos = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = $connection->query('SELECT * FROM bingo_templates ORDER BY RAND() LIMIT 3');
        $randomBingos = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($randomBingos as $index => $randomBingo) {
            setcookie($userCookiePrefix . $index, $randomBingo['template_id'], time() + (86400 * 30), "/");
        }
    }

    $_SESSION['randomBingoIds'] = array_column($randomBingos, 'template_id');
}

?>