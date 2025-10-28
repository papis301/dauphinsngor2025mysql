<?php
require 'db.php';

// Récupérer toutes les images depuis la base
$stmt = $conn->query("SELECT * FROM galleries ORDER BY uploaded_at DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie - Dauphins de Ngor</title>

    <!-- Liens CSS du template -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/lightcase.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="shortcut icon" href="assets/images/dauphinfavi.png" type="image/x-icon">
</head>

<body>

<?php include 'header.php'; ?>

<!-- ========== Galerie ========== -->
<div class="gallery-section padding-top padding-bottom">
    <div class="container">
        <div class="gallery-wrapper">

            <?php if (!empty($images)): ?>
                <?php foreach ($images as $img): ?>
                    <?php 
                        $filename = htmlspecialchars($img['filename'] ?? '');
                        $title = htmlspecialchars($img['title'] ?? 'Photo');
                        if (!empty($filename)): 
                    ?>
                        <div class="gallery-item">
                            <div class="gallery-thumb">
                                <img src="uploads/gallery/<?= $filename ?>" alt="<?= $title ?>">
                                <a href="uploads/gallery/<?= $filename ?>" data-rel="lightcase:myCollection" title="<?= $title ?>">
                                    <i class="flaticon-eye"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center w-100">Aucune image disponible pour le moment.</p>
            <?php endif; ?>

        </div>

        <div class="load-more text-center mt-4 mt-sm-5">
            <a href="upload_gallery.php" class="custom-button">+ Ajouter des images</a>
        </div>
    </div>
</div>
<!-- ========== Fin Galerie ========== -->

<?php include 'footer.php'; ?>

<!-- JS -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/lightcase.js"></script>
<script>
    $(document).ready(function() {
        $('a[data-rel^=lightcase]').lightcase();
    });
</script>

</body>
</html>
