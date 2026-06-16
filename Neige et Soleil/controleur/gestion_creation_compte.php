<?php 

    if(isset($_POST['ajouter'])){

        $erreurs = [];

        $type = $_POST['type'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $adresse = $_POST['adresse'];
        $cp = $_POST['cp'];
        $ville = $_POST['ville'];
        $tel = $_POST['tel'];
        $rib = $_POST['rib'];

        $regexNom = '/^[A-Za-zÀ-ÖØ-öø-ÿ\' -]{2,}$/u';
        $regexPrenom = '/^[A-Za-zÀ-ÖØ-öø-ÿ\' -]{2,}$/u';
        $regexEmail = '/^[A-Za-zÀ-ÖØ-öø-ÿ0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/u';
        $regexMdp = '/^[^ ]{3,}$/u';
        $regexAdresse = '/^[0-9]{1,5} [A-Za-zÀ-ÖØ-öø-ÿ\' .-]{3,}$/u';
        $regexCp = '/^[0-9]{5}$/';
        $regexVille = '/^[A-Za-zÀ-ÖØ-öø-ÿ\' -]{2,}$/u';
        $regexTel = '/^[0-9]{10}$/';
        $regexRib = '/^[0-9A-Z]{27}$/';


        $champs = [$type,$nom,$prenom,$email,$mdp,$adresse,$cp,$ville,$tel,$rib];

        foreach($champs as $champ){
                if($champ == ""){
                        $erreurs[] = "Veuillez remplir touts les champs";
                        break;
                }
        }

        $regles = [
                        "nom" => [$regexNom,     "Veuillez saisir un nom valide"],
                        "prenom" => [$regexPrenom,  "Veuillez saisir un prénom valide"],
                        "email" => [$regexEmail,   "Veuillez saisir un email valide"],
                        "mdp" => [$regexMdp,     "Veuillez saisir un mot de passe valide"],
                        "adresse" => [$regexAdresse, "Veuillez saisir une adresse valide"],
                        "cp" => [$regexCp,      "Veuillez saisir un code postal valide"],
                        "ville" => [$regexVille,   "Veuillez saisir un nom de ville valide"],
                        "tel" => [$regexTel,     "Veuillez saisir un numéro de téléphone valide"],
                        "rib" => [$regexRib,     "Veuillez saisir un RIB valide"]
        ];

        foreach($regles as $champ => [$regex, $msg]){
                if(!preg_match($regex, trim($_POST[$champ]))){
                        $erreurs[] = $msg;
                        break;
                }
        }





        if(!empty($erreurs)){
                $_SESSION['msg-erreurs'] = $erreurs;
        }else{
                if($type == 'client'){
                        $unControleur->insertClient([
                                "nom" => $nom,
                                "prenom" => $prenom,
                                "email" => $email,
                                "mdp" => $mdp,
                                "tel" => $tel,
                                "adresse" => $adresse,
                                "cp" => $cp,
                                "ville" => $ville,
                                "rib" => $rib
                                ]);
        
                        header("Location: index.php?page=16");
                        exit;
                        
                }
                if($type == 'proprietaire'){
                        $unControleur->insertProprietaire([
                                "nom" => $nom,
                                "prenom" => $prenom,
                                "email" => $email,
                                "mdp" => $mdp,
                                "tel" => $tel,
                                "adresse" => $adresse,
                                "cp" => $cp,
                                "ville" => $ville,
                                "rib" => $rib
                                ]);
                        header("Location: index.php?page=16");
                        exit;
                }
        }

}

if(isset($_POST['annuler'])){
        header("Location: index.php?page=8");
        exit;
}

        require_once("vue/vue_creation_compte.php");
?>