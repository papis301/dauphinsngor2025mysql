<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
/* if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
} */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard - Administration</title>

<!-- Bootstrap 5 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-primary sidebar collapse text-white" style="min-height: 100vh;">
            <div class="position-sticky p-3">
                <h4 class="text-center mb-4 text-white">DAUPHINS NGOR</h4>

                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="dashboard.php">🏠 Accueil</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="ajouter_actualite.php">➕ Ajouter Actualité</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="videos_youtube.php">📰 Liste Actualités</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white" href="gestion_images.php">🎥 Gestion Médias</a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="btn btn-danger w-100" href="logout.php">🚪 Déconnexion</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- CONTENU PRINCIPAL -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div class="py-4">
                <h1 class="fw-bold mb-4">Tableau de Bord Administrateur</h1>

                <!-- CARDS -->
                <div class="row g-4">

                    <div class="col-md-4">
                        <a href="ajouter_actualite.php" class="text-decoration-none">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <h3>➕ Ajouter Actualité</h3>
                                    <p class="text-muted">Ajouter une image ou vidéo YouTube/TikTok</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="videos_youtube.php" class="text-decoration-none">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <h3>📰 Actualités</h3>
                                    <p class="text-muted">Modifier / Supprimer les actualités</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="gestion_images.php" class="text-decoration-none">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <h3>🎥 Médias</h3>
                                    <p class="text-muted">Gérer les images et vidéos</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
