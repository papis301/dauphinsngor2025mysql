<?php
require_once 'db.php';
session_start();

$message = "";

// Fonction de redimensionnement
function resizeImage($source, $destination, $maxWidth = 1200, $quality = 85)
{
    list($width, $height, $type) = getimagesize($source);
    $ratio = $width / $height;

    // Si l'image est déjà plus petite, ne rien faire
    if ($width <= $maxWidth) {
        move_uploaded_file($source, $destination);
        return true;
    }

    $newWidth = $maxWidth;
    $newHeight = $maxWidth / $ratio;

    switch ($type) {
        case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($source); break;
        case IMAGETYPE_PNG:  $img = imagecreatefrompng($source); break;
        case IMAGETYPE_GIF:  $img = imagecreatefromgif($source); break;
        case IMAGETYPE_WEBP: $img = imagecreatefromwebp($source); break;
        default: return false;
    }

    $newImg = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG: imagejpeg($newImg, $destination, $quality); break;
        case IMAGETYPE_PNG:  imagepng($newImg, $destination); break;
        case IMAGETYPE_GIF:  imagegif($newImg, $destination); break;
        case IMAGETYPE_WEBP: imagewebp($newImg, $destination, $quality); break;
    }

    imagedestroy($img);
    imagedestroy($newImg);
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {

    $uploadDir = "uploads/gallery/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxSize = 5 * 1024 * 1024;

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp) {

        if ($tmp == "") continue;

        $fileName = $_FILES['images']['name'][$key];
        $fileSize = $_FILES['images']['size'][$key];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Nom unique
        $newName = uniqid("img_", true) . "." . $fileExt;
        $filePath = $uploadDir . $newName;

        if (!in_array($fileExt, $allowedExt)) {
            $message .= "<div class='alert alert-danger'>❌ $fileName : Extension non autorisée</div>";
            continue;
        }

        if ($fileSize > $maxSize) {
            $message .= "<div class='alert alert-danger'>❌ $fileName : Fichier trop volumineux (max 5 Mo)</div>";
            continue;
        }

        if (!getimagesize($tmp)) {
            $message .= "<div class='alert alert-danger'>❌ $fileName : Ce n'est pas une image valide</div>";
            continue;
        }

        // Redimensionnement / Upload
        if (resizeImage($tmp, $filePath)) {
            $stmt = $db->prepare("INSERT INTO galleries (filename) VALUES (?)");
            $stmt->execute([$newName]);
            $message .= "<div class='alert alert-success'>✔️ $fileName importée avec succès !</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter plusieurs images</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">
    <a href="galerie_images.php" class="btn btn-secondary mb-3">⬅ Retour Galerie</a>
    <h2 class="mb-3">📁 Upload Multiple d'Images</h2>

    <?= $message ?>

    <form method="POST" enctype="multipart/form-data" class="p-4 bg-white shadow-sm rounded">
        <label class="form-label">Sélectionner plusieurs images :</label>
        <input type="file" name="images[]" class="form-control mb-3" multiple required>
        <small class="text-muted">Formats acceptés : JPG, PNG, GIF, WEBP — Max 5 Mo / image</small>

        <button class="btn btn-primary mt-3">📤 Télécharger</button>
    </form>
</div>

</body>
</html>
