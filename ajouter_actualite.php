<?php
require_once 'db.php';

// Fonction pour convertir automatiquement les liens YouTube/TikTok en embed
function convertToEmbed($url) {
    $url = trim($url);

    // YouTube normal : https://www.youtube.com/watch?v=XXXX
    if (strpos($url, "youtube.com/watch") !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        return "https://www.youtube.com/embed/" . $params['v'];
    }

    // YouTube court : https://youtu.be/XXXX
    if (strpos($url, "youtu.be") !== false) {
        $id = basename($url);
        return "https://www.youtube.com/embed/" . $id;
    }

    // TikTok
    if (strpos($url, "tiktok.com") !== false) {
        return str_replace("/video/", "/embed/", $url);
    }

    return $url;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $type_media = $_POST['type_media']; // Nouveau champ

    $video_url = null;
    $media = null;

    // Dossier upload
    $uploadDir = __DIR__ . '/uploads/actualites/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    if ($type_media === 'youtube' || $type_media === 'tiktok') {
        $video_url = convertToEmbed($_POST['video_url']);
    } elseif ($type_media === 'image' || $type_media === 'video') {
        if (!empty($_FILES['media']['name'])) {
            $filename = time() . "_" . basename($_FILES['media']['name']);
            $filePath = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['media']['tmp_name'], $filePath)) {
                $media = $filename;
            } else {
                $message = "<div class='alert alert-danger'>Erreur lors de l'upload du fichier.</div>";
            }
        }
    }

    // Insertion DB
    $sql = $db->prepare("INSERT INTO actualites (titre, description, media, video_url, type_media, date_creation) VALUES (?, ?, ?, ?, ?, NOW())");
    $sql->execute([$titre, $description, $media, $video_url, $type_media]);

    $message = "<div class='alert alert-success'>Actualité ajoutée avec succès !</div>";
}
?>

<?php include 'header.php'; ?>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">➕ Ajouter une Actualité</h2>

        <?= $message ?>

        <form action="" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-white shadow">

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Type de média</label>
                <select name="type_media" class="form-control" required>
                    <option value="image">Image locale</option>
                    <option value="video">Vidéo locale</option>
                    <option value="youtube">YouTube</option>
                    <option value="tiktok">TikTok</option>
                </select>
            </div>

            <hr>

            <h5>📁 Ajouter un fichier (si type image ou vidéo)</h5>

            <div class="mb-3">
                <label class="form-label">Fichier (image ou vidéo)</label>
                <input type="file" name="media" class="form-control" accept="image/*,video/*">
            </div>

            <div class="text-center mb-3">
                <strong>OU</strong>
            </div>

            <div class="mb-3">
                <label class="form-label">Lien YouTube / TikTok (si type correspondant)</label>
                <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/... OU https://www.tiktok.com/...">
            </div>

            <button type="submit" class="btn btn-success w-100">Ajouter</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>
