<?php 
    require_once("vue/vue_changement_mdp.php");
    if(isset($_POST['Valider'])){
        $nvMdp = $_POST['nvMdp'];
        $confirmationNvMdp = $_POST['confirmationNvMdp'];
        $email = $_SESSION['email'];
        $role = $_SESSION['role'];

        if($nvMdp == $confirmationNvMdp){
            $unControleur->changerMdp($email,$nvMdp);
            $_SESSION['msg-confirm-changement-mdp'] = 'Mot de passe modifié avec succés ✅';
            header("Location:index.php?page=8");
        }else{
            echo '<br>';
            echo '<section>';
            echo '<h3 style="color:red;">Mots de passe différents, renouvellez votre saisie !</h3>';
            echo '</section>';
        }
    }
?>