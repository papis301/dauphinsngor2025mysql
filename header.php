<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dauphins de Ngor</title>
    <link rel="shortcut icon" href="assets/images/dauphinfavi.png" type="image/x-icon">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/lightcase.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/swiper.min.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<!-- Bouton retour haut -->
<a href="#0" class="scrollToTop" title="ScrollToTop">
    <img src="assets/images/rocket.png" alt="rocket">
</a>

<!-- ========== HEADER ========== -->
<!-- ========== HEADER ========== -->
<header class="header-section">

    <!-- Top bar desktop uniquement -->
    <div class="header-top d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <ul class="header-top-info">
                        <li>
                            <div class="left"><i class="flaticon-phone-call"></i></div>
                            <div class="right">
                                <span class="d-block">Appelez-nous</span>
                                <a href="tel:+221771267575">+221 77 126 75 75</a>
                            </div>
                        </li>
                        <li>
                            <div class="left"><i class="flaticon-placeholder"></i></div>
                            <div class="right">
                                <span class="d-block">Adresse</span>
                                <a href="#0">Plage de NGOR</a>
                            </div>
                        </li>
                        <li>
                            <div class="left"><i class="flaticon-clock"></i></div>
                            <div class="right">
                                <span class="d-block">Heures d'ouverture</span>
                                <a href="#0">7h00 - 11h30 (Vendredi fermé)</a>
                            </div>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Header principal -->
    <div class="header-bottom">
        <div class="container">
            <div class="header-wrapper">

                <!-- LOGO -->
                <div class="logo">
                    <a href="index.php">
                        <img src="assets/images/logo/logo.png" alt="logo">
                    </a>
                </div>

                <!-- BOUTON MOBILE -->
                <div class="mobile-menu-toggle d-lg-none">
                    <span class="menu-icon"><i class="fas fa-bars"></i></span>
                </div>

                <!-- MENU -->
                <ul class="menu ml-auto d-none d-lg-flex">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="leclub.php">Le Club</a></li>
                    <li><a href="galerie.php">Galeries</a></li>
                    <li><a href="videos_youtube.php">Actualités</a></li>
                    <li><a href="boutique.php">Boutique</a></li>
                </ul>

            </div>
        </div>
    </div>

    <!-- MENU MOBILE (CACHÉ PAR DÉFAUT) -->
    <div class="mobile-menu d-lg-none">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="leclub.php">Le Club</a></li>
            <li><a href="galerie.php">Galeries</a></li>
            <li><a href="videos_youtube.php">Actualités</a></li>
            <li><a href="boutique.php">Boutique</a></li>
        </ul>
    </div>

</header>
<!-- ========== FIN HEADER ========== -->


<script>
function toggleMobileMenu() {
    document.getElementById("mobileMenu").classList.toggle("active");
}
</script>
