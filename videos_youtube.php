<?php
require_once 'db.php';
include 'header.php';

// Récupérer toutes les vidéos YouTube et TikTok
$sql = $db->query("SELECT * FROM actualites WHERE type_media IN ('youtube') ORDER BY date_creation DESC");
$videos = $sql->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour obtenir la miniature TikTok (via l'URL publique)
function getTikTokThumbnail($url) {
    // Si l'URL est valide
    if (!$url) return '';
    // Ajouter /image endpoint pour avoir une miniature (TikTok ne fournit pas API gratuite officielle)
    // Solution simple : utiliser le lien d’aperçu via le site tiers ou laisser une image par défaut
    return 'assets/images/tiktok_placeholder.png'; // tu peux mettre un placeholder
}
?>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">🎬 Toutes les vidéos</h2>

        <div class="row">
            <?php foreach ($videos as $video): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm rounded">
                        <?php if ($video['type_media'] === 'youtube' && !empty($video['video_url'])): ?>
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="<?= htmlspecialchars($video['video_url']) ?>" 
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        <?php elseif ($video['type_media'] === 'tiktok' && !empty($video['video_url'])): ?>
                            <a href="<?= htmlspecialchars($video['video_url']) ?>" target="_blank">
                                <img src="<?= getTikTokThumbnail($video['video_url']) ?>" class="img-fluid" alt="TikTok Video">
                            </a>
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($video['titre']) ?></h5>
                            <p class="card-text"><?= substr(htmlspecialchars($video['description']),0,100) ?>...</p>
                            <small class="text-secondary">📅 <?= date("d/m/Y H:i", strtotime($video['date_creation'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
