<?php
$uploadDir = "uploads/";
if (isset($_FILES['meme']) && $_FILES['meme']['error'] == 0) {
    $fileTmp = $_FILES['meme']['tmp_name'];
    $fileName = basename($_FILES['meme']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($fileExt, $allowed)) {
        $newName = uniqid("meme_", true) . "." . $fileExt;
        $target = $uploadDir . $newName;
        if (move_uploaded_file($fileTmp, $target)) {
            // Save caption
            if (!empty($_POST['caption'])) {
                $captionFile = $target . ".txt";
                file_put_contents($captionFile, htmlspecialchars($_POST['caption']));
            }
            header("Location: index.html"); // Go back to homepage
            exit();
        } else {
            echo "Error: Upload failed.";
        }
    } else {
        echo "Only image files are allowed.";
    }
} else {
    echo "No file uploaded or an error occurred.";
}
?>
