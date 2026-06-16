<?php 
//recup infos formulaire
    if(isset($_POST['Connexion'])){
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

        $unUtilisateur = $unControleur->selectWhereUtilisateur($email,$mdp);

        if(!$unUtilisateur){
            $_SESSION['msg-erreur-connexion'] = "Identifiants incorrects";
        }else{
                //gestion temps
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

    require_once("vue/vue_connexion.php");
?>

