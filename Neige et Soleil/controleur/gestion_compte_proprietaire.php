<?php 
    $id = $_SESSION['id'];
    $utilisateur = $unControleur->selectWhereIdUtilisateur($id);
    $leProprietaire = $unControleur->selectWhereIdProprietaire($id);

    if(isset($_GET['action']) && isset($_GET['ref_hab'])){
        $refHab = $_GET['ref_hab'];
        $unControleur->deleteMaison($refHab);
        $unControleur->deleteAppartement($refHab);
        $_SESSION['msg-supp-habitation'] = "Votre habitation a été supprimée avec succés✅";
    }
    
    $habProprio = $unControleur->selectHabitationWhereProprietaire($_SESSION['id']);
    
    require_once("vue/vue_compte_proprietaire.php");
    
?>