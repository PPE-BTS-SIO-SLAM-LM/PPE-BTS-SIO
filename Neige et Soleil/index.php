<?php
    session_start();
    require_once __DIR__ . "/parametres.php";
    require_once("controleur/controleur.class.php");
    $unControleur = new Controleur();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neige et Soleil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="scripts.js" defer></script>
</head>
<body>
<!-- Header -->
<header>
    <a href="index.php">
        <img id="logo" src= "images/logo-neige-soleil.png" alt="logo">
    </a>
    <ul>
        <?php if(isset($_SESSION['email']) && $_SESSION['role'] == 'client'):?>
            <li><a href="index.php">Accueil</a> </li>
            <li><a href="index.php?page=6">Espace</a></li>
            <li><a href="index.php?page=9">Déconnexion</a></li>
        <?php endif; ?>
        <?php if(isset($_SESSION['email']) && $_SESSION['role'] == 'proprietaire'):?>
            <li><a href="index.php">Accueil</a> </li>
            <li><a href="index.php?page=7">Espace</a></li>
            <li><a href="index.php?page=9">Déconnexion</a></li>
        <?php endif;?>
        <?php if(isset($_SESSION['email']) && $_SESSION['role'] == 'admin'):?>
            <li><a href="index.php">Accueil</a> </li>
            <li><a href="index.php?page=2">Clients</a></li>
            <li><a href="index.php?page=3">Propriétaires</a></li>
            <li><a href="index.php?page=4">Habitations</a></li>
            <li><a href="index.php?page=5">Réservations</a></li>
            <li><a href="index.php?page=9">Déconnexion</a></li>
        <?php endif;?>
    </ul>
</header>

<!-- Main -->
 <main>
    <?php
    //protection accés pages sensibles
    $pageProtege = [
        2 => ['admin'],
        3 => ['admin'],
        4 => ['admin'],
        5 => ['admin'],
        6 => ['client'],
        7 => ['proprietaire'],
        11 => ['client'],
        12 => ['client'],
        13 => ['proprietaire'],
        14 => ['proprietaire'],
        20 => ['client'],
        21 => ['proprietaire'],
        22 => ['proprietaire']
    ];

    $page = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

    if(isset($pageProtege[$page])){
        if(!isset($_SESSION['email']) || !isset($_SESSION['role'])){
            header("Location: index.php?page=1");
            exit;
        }
        if(!in_array($_SESSION['role'], $pageProtege[$page])){
            header("Location: index.php?page=1");
            exit;
        }
    }

    //routeur accés pages 
    switch($page){
        case 1 : require_once("controleur/home.php"); break;
        case 2 : require_once("controleur/gestion_client.php"); break;
        case 3 : require_once("controleur/gestion_proprietaire.php"); break;
        case 4 : require_once("controleur/gestion_habitat.php"); break;
        case 5 : require_once("controleur/gestion_reservation.php"); break;
        case 6 : require_once("controleur/gestion_compte_client.php");break;
        case 7 : require_once("controleur/gestion_compte_proprietaire.php");break;
        case 8 : require_once("controleur/gestion_connexion.php");break;
        case 9 : 
            session_destroy(); 
            header("Location: index.php");
            exit;
        break;
        case 10 : require_once("controleur/gestion_reservation_habitation.php");break;
        case 11 : require_once("controleur/gestion_confirmation_reservation.php");break;
        case 12 : require_once("controleur/gestion_reservation_confirmee.php");break;
        case 14 : require_once("controleur/gestion_creation_annonce_confirmee.php");break;
        case 15 : require_once("controleur/gestion_creation_compte.php");break;
        case 16 : require_once("controleur/gestion_creation_compte_confirmee.php");break;
        case 17 : require_once("controleur/gestion_mdp_oublie.php");break;
        case 18 : require_once("controleur/gestion_confirmation_mdp_oublie.php");break;
        case 19 : require_once("controleur/gestion_nouveau_mdp_valide.php");break;
        case 20 : require_once("controleur/gestion_update_client.php");break;
        case 21 : require_once("controleur/gestion_update_proprietaire.php");break;
        case 23 : require_once("controleur/gestion_choix_creation_annonce.php");break;
        case 24 : require_once("controleur/gestion_creation_annonce_maison.php");break;
        case 25 : require_once("controleur/gestion_creation_annonce_appartement.php");break;
        case 26 : require_once("controleur/gestion_update_maison.php");break;
        case 27 : require_once("controleur/gestion_update_appartement.php");break;
        case 28 : require_once("controleur/gestion_maison.php");break;
        case 29 : require_once("controleur/gestion_appartement.php");break;
        default : header("Location: controleur/erreur.php");break;
    }
?>
</main>

<!-- Footer -->
<footer>
    <p>&copy;Site neige et soleil - Tous droits réservés - Mentions légales</p>
</footer>

</body>
</html>