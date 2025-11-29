<?php
require_once 'db.php';
if (!isset($_POST['images'])) { header("Location: galerie_images.php"); exit; }

$ids = $_POST['images'];
$in = str_repeat('?,', count($ids) - 1) . '?';

// Récupérer les fichiers avant suppression
$stmt = $db->prepare("SELECT filename FROM galleries WHERE id IN ($in)");
$stmt->execute($ids);
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Supprimer fichiers physiques
foreach ($files as $file) {
    $path = "uploads/gallery/" . $file['filename'];
    if (file_exists($path)) unlink($path);
}

// Supprimer en DB
$del = $db->prepare("DELETE FROM galleries WHERE id IN ($in)");
$del->execute($ids);

header("Location: gestion_images.php?deleted=1");
exit;
?>