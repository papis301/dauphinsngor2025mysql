<?php
require 'db.php';

if (isset($_POST['submit'])) {
    $files = $_FILES['images'];

    // Dossier de destination
    $uploadDir = 'uploads/gallery/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Parcourir les fichiers
    for ($i = 0; $i < count($files['name']); $i++) {
        $fileName = basename($files['name'][$i]);
        $targetFile = $uploadDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Vérification du type
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowed)) {
            if (move_uploaded_file($files['tmp_name'][$i], $targetFile)) {
                $stmt = $conn->prepare("INSERT INTO galleries (filename) VALUES (?)");
                $stmt->execute([$fileName]);
            }
        }
    }

    echo "<p style='color:green;'>✅ Images ajoutées avec succès !</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter des images - Galerie</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h2>📸 Ajouter des images dans la galerie</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple accept="image/*" required>
        <button type="submit" name="submit">Téléverser</button>
    </form>

    <br><a href="gallery.php">Voir la galerie →</a>
</body>
</html>
