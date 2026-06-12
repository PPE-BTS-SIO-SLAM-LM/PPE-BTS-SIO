<?php 

$idProprietaire = $_SESSION['id'];
$leProprietaire = $unControleur->selectWhereIdProprietaire($idProprietaire);
$erreurs = [];
        
if (isset($_POST['ajouter'])){


        $photos = $_FILES['photos'];
        $formats = array("jpg","jpeg","png","avif");
        $tailleMax = 4 * 1024 * 1024;

        $id_p = $_POST['id_p'];
        $adr_hab = $_POST['adr_hab'];
        $cp_hab = $_POST['cp_hab'];
        $ville_hab = $_POST['ville_hab'];
        $tarif_hab_bas = $_POST['tarif_hab_bas'];
        $tarif_hab_moyen = $_POST['tarif_hab_moy'];
        $tarif_hab_haut = $_POST['tarif_hab_hau'];
        $surface = $_POST['surface'];   
        $description_hab = $_POST['description_hab'];
        $titre_hab = $_POST['titre_hab'];
        $capacite_hab = $_POST['capacite_hab'];
        $carac_m = $_POST['carac_m'];

        $regexAdresse = '/^[0-9]{1,5} [A-Za-zÀ-ÖØ-öø-ÿ\' .-]{3,}$/u';
        $regexCp = '/^[0-9]{5}$/';
        $regexVille = '/^[A-Za-zÀ-ÖØ-öø-ÿ\' -]{2,}$/u';
        $regexTarifs = '/^[0-9]{1,5}([.,][0-9]{0,2})?$/';
        $regexSurface = '/^[1-9][0-9]{0,2}$/';
        $regexCapacite = '/^[1-9][0-9]{0,1}$/';


        $champs = [$adr_hab, $cp_hab, $ville_hab,
                   $tarif_hab_bas, $tarif_hab_moyen, $tarif_hab_haut,
                   $surface, $description_hab, $titre_hab, $capacite_hab,$carac_m
                  ];

        foreach ($champs as $champ) {
                if ($champ === "") {
                        $erreurs[] = "Veuillez remplir tous les champs";break;
                }
        }

        $regles = [
                        "adr_hab" => [$regexAdresse, "Veuillez rentrer une adresse valide"],
                        "cp_hab" => [$regexCp,      "Veuillez rentrer un code postal valide"],
                        "ville_hab" => [$regexVille,   "Veuillez rentrer un nom de ville valide"],
                        "tarif_hab_bas" => [$regexTarifs, "Veuillez rentrer un tarif bas valide"],
                        "tarif_hab_moy" => [$regexTarifs, "Veuillez rentrer un tarif moyenvalide"],
                        "tarif_hab_hau" => [$regexTarifs, "Veuillez rentrer un tarif haut valide"],
                        "surface"  => [$regexSurface, "Veuillez rentrer une surface valide"],
                        "capacite_hab"  => [$regexCapacite, "Veuillez rentrer une capacité valide"]
        ];

        foreach($regles as $champ => [$regex, $msg]){
                if(!preg_match($regex, trim($_POST[$champ]))){
                        $erreurs[] = $msg;
                        break;
                }
        }

        $nbPhotos = count(array_filter($photos['name']));

        if ($nbPhotos !== 3) {
                $erreurs[] = "Veuillez sélectionner exactement 3 photos.";      
        }else{
                foreach ($photos['name'] as $i => $name) {
                        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                        if (!in_array($extension, $formats)) {
                                $erreurs[] = "Format non autorisé pour la photo : $name";
                        }
                        if($photos['size'][$i] > $tailleMax){
                                $erreurs[] = "Taille de la photo non autorisé : $name";
                        }
                        if ($photos['error'][$i] !== UPLOAD_ERR_OK) {
                                $erreurs[] = "Erreur lors de l'upload de la photo : $name";
                        }
                }
        }
        


        if (!empty($erreurs)) { 
                $_SESSION['erreurs'] = $erreurs;
        }else{
                //ajouter les insert dans photos et habitations
                $refHab = $unControleur->insertMaison([
                        "adr_hab" => $adr_hab,
                        "cp_hab" => $cp_hab,
                        "ville_hab" => $ville_hab,
                        "tarif_hab_bas" => $tarif_hab_bas,
                        "tarif_hab_moy" => $tarif_hab_moyen,
                        "tarif_hab_hau" => $tarif_hab_haut,
                        "surface" => $surface,
                        "id_p" => $id_p,
                        "description_hab" => $description_hab,
                        "titre_hab" => $titre_hab,
                        "capacite_hab" => $capacite_hab,
                        "carac_m" => $carac_m
                ]);
                
                foreach ($photos['name'] as $i => $name) {

                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                $newName = uniqid("photo_") . "." . $extension;

                move_uploaded_file($photos['tmp_name'][$i], "images/habitations/" . $newName);

                $isPrincipal = ($i === 0) ? 1 : 0;

                $unControleur->insertPhoto([
                        "ref_hab" => $refHab,
                        "url_photo" => $newName,
                        "is_principal" => $isPrincipal
                        ]);
                }

                header("Location: index.php?page=14");
                exit;
        }

}

if(isset($_POST['annuler'])){
        header("Location: index.php?page=7");
        exit;
}

        require_once("vue/vue_creation_annonce_maison.php");
 
?>