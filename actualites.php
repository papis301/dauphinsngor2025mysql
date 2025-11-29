<?php
require_once 'db.php';

// =============================
// Récupération des actualités
// =============================
$sql = $db->query("SELECT * FROM actualites ORDER BY date_creation DESC");
$actualites = $sql->fetchAll(PDO::FETCH_ASSOC);

// =============================
// FONCTIONS UTILITAIRES
// =============================

// Extraction ID YouTube : compatible watch, embed, youtu.be, shorts
function getYouTubeID($url) {
    $url = strtok($url, '?'); // enlever paramètres éventuels
    $pattern = '%(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{6,})%i';
    if (preg_match($pattern, $matches = [], $matches)) {
        return $matches[1];
    }
    return null;
}

// Miniature TikTok via oEmbed
function getTikTokThumbnail($url) {
    $oembedUrl = "https://www.tiktok.com/oembed?url=" . urlencode($url);
    $json = @file_get_contents($oembedUrl);
    if ($json) {
        $data = json_decode($json, true);
        if (!empty($data['thumbnail_url'])) return $data['thumbnail_url'];
    }
    return null;
}
?>

<?php include 'header.php'; ?>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">📢 Liste des Actualités</h2>

        <div class="row">
            <?php foreach ($actualites as $actu) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm rounded">

                        <?php
                        // ===== Image locale =====
                        if ($actu['type_media'] === 'image') {
                            ?>
                            <img src="uploads/actualites/<?php echo htmlspecialchars($actu['media']); ?>"
                                 class="card-img-top" style="height:230px; object-fit:cover;">
                            <?php
                        }
                        // ===== Vidéo locale =====
                        elseif ($actu['type_media'] === 'video') {
                            ?>
                            <video controls style="width:100%; height:230px; object-fit:cover;">
                                <source src="uploads/actualites/<?php echo htmlspecialchars($actu['media']); ?>" type="video/mp4">
                            </video>
                            <?php
                        }
                        // ===== YouTube =====
                        elseif ($actu['type_media'] === 'youtube') {
                            $ytID = getYouTubeID($actu['media']);
                            if ($ytID) {
                                ?>
                                <iframe width="100%" height="230"
                                    src="https://www.youtube.com/embed/<?php echo $ytID; ?>"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                                <?php
                            } else {
                                ?>
                                <div style="height:230px; background:#000; display:flex; align-items:center; justify-content:center;">
                                    <span class="text-white">Vidéo YouTube</span>
                                </div>
                                <?php
                            }
                        }
                        // ===== TikTok =====
                        elseif ($actu['type_media'] === 'tiktok') {
                            $thumb = getTikTokThumbnail($actu['media']);
                            if ($thumb) {
                                ?>
                                <a href="<?php echo htmlspecialchars($actu['media']); ?>" target="_blank">
                                    <img src="<?php echo $thumb; ?>"
                                         class="card-img-top" style="height:230px; object-fit:cover;">
                                </a>
                                <?php
                            } else {
                                ?>
                                <a href="<?php echo htmlspecialchars($actu['media']); ?>" target="_blank">
                                    <div style="height:230px; background:#000; display:flex; align-items:center; justify-content:center;">
                                        <span class="text-white">Vidéo TikTok</span>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        // ===== Aucun média =====
                        else {
                            ?>
                            <div style="height:230px; background:#eee; display:flex; align-items:center; justify-content:center;">
                                <span class="text-muted">Aucun média</span>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($actu['titre']); ?></h5>
                            <p class="card-text text-muted"><?php echo substr(htmlspecialchars($actu['description']), 0, 80); ?>...</p>
                            <small class="text-secondary">📅 <?php echo date("d/m/Y H:i", strtotime($actu['date_creation'])); ?></small>
                            <hr>
                            <a href="voir_actualite.php?id=<?php echo $actu['id']; ?>" class="btn btn-sm btn-info">👁 Voir</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section>

<?php include 'footer.php'; ?>
