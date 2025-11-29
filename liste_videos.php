<?php
require_once 'db.php';
session_start();

/* if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
} */

// Récupération des vidéos YouTube
$sql = $db->query("SELECT * FROM actualites WHERE type_media = 'youtube' ORDER BY date_creation DESC");
$videos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion des Vidéos YouTube</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">

    <a href="dashboard.php" class="btn btn-secondary mb-4">⬅ Retour Dashboard</a>

    <h2 class="mb-4">🎥 Gestion des Vidéos YouTube</h2>

    <?php if (empty($videos)): ?>
        <div class="alert alert-warning">Aucune vidéo YouTube ajoutée pour le moment.</div>
    <?php else: ?>

        <div class="row">
            <?php foreach ($videos as $vid): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">

                        <!-- Preview Vidéo -->
                        <div class="ratio ratio-16x9">
                            <iframe src="<?= htmlspecialchars($vid['video_url']) ?>" allowfullscreen></iframe>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($vid['titre']) ?></h5>

                            <p class="text-muted mb-2">
                                Publié le <?= date("d/m/Y H:i", strtotime($vid['date_creation'])) ?>
                            </p>

                            <div class="d-flex justify-content-between">
                                <a href="modifier_actualite.php?id=<?= $vid['id'] ?>" class="btn btn-primary btn-sm">
                                    ✏ Modifier
                                </a>

                                <a href="supprimer_actualite.php?id=<?= $vid['id'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Supprimer cette vidéo ?');">
                                    🗑 Supprimer
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
