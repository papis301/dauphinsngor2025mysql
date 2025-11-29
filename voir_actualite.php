<?php
require_once 'db.php';

if (!isset($_GET['id'])) {
    die("Actualité non trouvée.");
}

$id = intval($_GET['id']);

// Récupération actualité
$sql = $db->prepare("SELECT * FROM actualites WHERE id = ?");
$sql->execute([$id]);
$actu = $sql->fetch(PDO::FETCH_ASSOC);

if (!$actu) {
    die("Cette actualité n'existe pas.");
}

// Récupération des images supplémentaires (si tu utilises une galerie)
//$images = $db->prepare("SELECT * FROM images_actualite WHERE actualite_id = ?");
//$images->execute([$id]);
//$images = $images->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<section class="py-5">
    <div class="container">

        <a href="actualites.php" class="btn btn-secondary mb-4">⬅ Retour</a>

        <h2 class="mb-3"><?= htmlspecialchars($actu['titre']) ?></h2>

        <p class="text-muted">
            📅 Publié le <?= date("d/m/Y à H:i", strtotime($actu['date_creation'])) ?>
        </p>

        <hr>

        <!-- MEDIA PRINCIPAL -->
        <div class="mb-4">

            <?php if ($actu['video_url']): ?>
                <!-- Vidéo YouTube ou TikTok -->
                <div class="ratio ratio-32x18">
                    <iframe 
                        src="<?= $actu['video_url'] ?>" 
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

            <?php elseif ($actu['media']): ?>

                <?php
                $extension = strtolower(pathinfo($actu['media'], PATHINFO_EXTENSION));
                $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'mkv']);
                ?>

                <?php if ($isVideo): ?>
                    <!-- Vidéo locale -->
                    <video controls class="w-100 rounded shadow">
                        <source src="uploads/actualites/<?= $actu['media'] ?>" type="video/mp4">
                    </video>

                <?php else: ?>
                    <!-- Image principale -->
                    <img src="uploads/actualites/<?= $actu['media'] ?>" class="img-fluid rounded shadow">
                <?php endif; ?>

            <?php endif; ?>

        </div>

        <!-- GALERIE IMAGES SUPPLÉMENTAIRES -->
        <?php if (!empty($images)): ?>
            <h4 class="mt-4">📸 Galerie</h4>
            <div class="row mt-3">
                <?php foreach ($images as $img): ?>
                    <div class="col-md-3 col-6 mb-3">
                        <img src="uploads/actualites/<?= $img['image'] ?>" class="img-fluid rounded shadow">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <hr>

        <!-- DESCRIPTION -->
        <div class="mt-4">
            <h4>📄 Description</h4>
            <p style="font-size: 18px; line-height: 1.6;">
                <?= nl2br(htmlspecialchars($actu['description'])) ?>
            </p>
        </div>

    </div>
</section>

<?php include 'footer.php'; ?>
