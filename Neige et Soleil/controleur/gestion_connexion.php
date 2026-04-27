<?php 
//recup infos formulaire
    if(isset($_POST['Connexion'])){
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        $unUtilisateur = $unControleur->selectWhereUtilisateur($email,$mdp);

        if(!$unUtilisateur){
            $_SESSION['msg-erreur-connexion'] = "Identifiants incorrects";
        }else{
            $dateMdp = $unUtilisateur['date_mdp'];
            $dateAjd = date('Y-m-d');
            $dateMdp = new DateTime($dateMdp);
            $dateAjd = new DateTime($dateAjd);
            $interval = $dateAjd->diff($dateMdp);
            $ecart = $interval->days;

            if($ecart >= 90){
                $_SESSION['email'] = $unUtilisateur['email'];
                $_SESSION['role'] = "changement mdp";
                header("Location:index.php?page=30");
                exit;
            }else{
                $_SESSION['email'] = $unUtilisateur['email'];
                $_SESSION['prenom'] = $unUtilisateur['prenom'];
                $_SESSION['nom'] = $unUtilisateur['nom'];
                $_SESSION['tel'] = $unUtilisateur['tel'];
                $_SESSION['role'] = $unUtilisateur['role'];
                $_SESSION['id'] = $unUtilisateur['id_user'];
                //on recharge la page
                header("Location: index.php?page=1");
                exit; 
            }
        }
    }

    require_once("vue/vue_connexion.php");
?>
