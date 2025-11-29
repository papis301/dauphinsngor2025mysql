<?php
require_once 'db.php';
session_start();

// Récupération des images
$sql = $db->query("SELECT * FROM galleries ORDER BY uploaded_at DESC");
$images = $sql->fetchAll(PDO::FETCH_ASSOC);

// Fonction format taille
function formatSize($file) {
    if (!file_exists($file)) return "Fichier manquant";
    $size = filesize($file);
    $units = ['o', 'Ko', 'Mo', 'Go']; $i = 0;
    while ($size >= 1024 && $i < count($units)-1) { $size /= 1024; $i++; }
    return round($size, 2)." ".$units[$i];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gestion Galerie Images</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container py-4">

<a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Retour Dashboard</a>
<h2 class="mb-4">🖼 Galerie d'Images</h2>

<?php if (empty($images)) : ?>
<div class="alert alert-warning">Aucune image enregistrée.</div>

<?php else : ?>
<form method="POST" action="supprimer_images.php" onsubmit="return confirm('Supprimer les images sélectionnées ?');">

<table class="table table-bordered table-hover bg-white shadow-sm">
<thead class="table-dark">
    <tr>
        <th><input type="checkbox" onclick="toggleAll(this)"></th>
        <th>Prévisualisation</th>
        <th>Nom du fichier</th>
        <th>Taille</th>
        <th>Date d'upload</th>
        <th>Actions</th>
    </tr>
</thead>

<tbody>
<?php foreach ($images as $img):
$filePath = "uploads/gallery/" . $img['filename'];
?>
<tr>
    <td><input type="checkbox" name="images[]" value="<?= $img['id'] ?>"></td>
    <td width="120"><img src="<?= $filePath ?>" class="img-fluid rounded" style="height:70px;object-fit:cover;"></td>
    <td><?= htmlspecialchars($img['filename']) ?></td>
    <td><span class="badge bg-info text-dark"><?= formatSize($filePath) ?></span></td>
    <td><?= date("d/m/Y H:i", strtotime($img['uploaded_at'])) ?></td>

    <td>
        <a href="<?= $filePath ?>" target="_blank" class="btn btn-primary btn-sm">👁 Voir</a>
        <a href="supprimer_image.php?id=<?= $img['id'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('Supprimer cette image ?');">🗑 Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<button type="submit" class="btn btn-danger mt-2">🗑 Supprimer la sélection</button>
</form>
<?php endif; ?>

</div>

<script>
function toggleAll(source) {
    let checkboxes = document.querySelectorAll('input[type="checkbox"][name="images[]"]');
    checkboxes.forEach(cb => cb.checked = source.checked);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
