<?php

$lesAppartements = $unControleur->selectAllAppartement();
$lesProprietaires = $unControleur->selectAllProprietaire();
$appartement = null;
$erreurs = [];



if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
	
	if(isset($_GET['action']) && isset($_GET['ref_hab'])){
		$action = $_GET['action'];
		$ref_hab = $_GET['ref_hab'];

		switch($action){
			case "sup" : $unControleur->deleteAppartement($ref_hab);
                                        $_SESSION['msg-reussite'] = "Suppression réussie de l'appartement ✅";
										header("Location:index.php?page=29");
										exit;
										break;
			case "edit" : $appartement = $unControleur->selectWhereAppartement($ref_hab);break;
		}
	}
}



if(isset($_POST['valider']) || isset($_POST['modifier'])){
	
	$photos = $_FILES['photos'];
    $formats = array("jpg","jpeg","png","avif");
    $tailleMax = 4 * 1024 * 1024;

	$ref_hab = $_POST['ref_hab'];
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
    $etage_ap = $_POST['etage_ap'];
    $type_ap = $_POST['type_ap'];

    $regexAdresse = '/^[0-9]{1,5} [A-Za-zÀ-ÖØ-öø-ÿ\' .-]{3,}$/u';
    $regexCp = '/^[0-9]{5}$/';
    $regexVille = '/^[A-Za-zÀ-ÖØ-öø-ÿ\' -]{2,}$/u';
    $regexTarifs = '/^[0-9]{1,5}([.,][0-9]{0,2})?$/';
    $regexSurface = '/^[1-9][0-9]{0,2}$/';
    $regexCapacite = '/^[1-9][0-9]{0,1}$/';
	
	$champs = [$adr_hab, $cp_hab, $ville_hab,
                $tarif_hab_bas, $tarif_hab_moyen, $tarif_hab_haut,
                $surface, $description_hab, $titre_hab, $capacite_hab,
                $etage_ap,$type_ap
			];
}



if(isset($_POST['valider'])){
	foreach ($champs as $champ) {
		if ($champ === "") {
			$erreurs[] = "Veuillez remplir tous les champs";break;
        }
    }

    $regles = [
				"adr_hab" => [$regexAdresse, "Veuillez saisir une adresse valide"],
                "cp_hab" => [$regexCp,      "Veuillez saisir un code postal valide"],
            	"ville_hab" => [$regexVille,   "Veuillez sasir un nom de ville valide"],
                "tarif_hab_bas" => [$regexTarifs, "Veuillez saisir un tarif bas valide"],
                "tarif_hab_moy" => [$regexTarifs, "Veuillez saisir un tarif moyenvalide"],
                "tarif_hab_hau" => [$regexTarifs, "Veuillez saisir un tarif haut valide"],
                "surface"  => [$regexSurface, "Veuillez saisir une surface valide"],
                "capacite_hab"  => [$regexCapacite, "Veuillez saisir une capacité valide"]
			];
    foreach($regles as $champ => [$regex, $msg]){
		if(!preg_match($regex, trim($_POST[$champ]))){
			$erreurs[] = $msg;break;
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
                $_SESSION['msg-erreurs'] = $erreurs; 
                header("Location:index.php?page=29"); 
                exit; 
        }else{
			$refHab = $unControleur->insertAppartement([
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
                "etage_ap" => $etage_ap,
                "type_ap" => $type_ap
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
		$_SESSION['msg-reussite'] = "Ajout réussi de l'appartement ✅";
		header("Location: index.php?page=29");
        exit;
	}
}



if(isset($_POST['modifier'])){
	foreach ($champs as $champ) {
		if ($champ === "") {
			$erreurs[] = "Veuillez remplir tous les champs";break;
        }
    }

    $regles = [
				"adr_hab" => [$regexAdresse, "Veuillez saisir une adresse valide"],
                "cp_hab" => [$regexCp,      "Veuillez saisir un code postal valide"],
            	"ville_hab" => [$regexVille,   "Veuillez saisir un nom de ville valide"],
                "tarif_hab_bas" => [$regexTarifs, "Veuillez saisir un tarif bas valide"],
                "tarif_hab_moy" => [$regexTarifs, "Veuillez saisir un tarif moyenvalide"],
                "tarif_hab_hau" => [$regexTarifs, "Veuillez saisir un tarif haut valide"],
                "surface"  => [$regexSurface, "Veuillez saisir une surface valide"],
                "capacite_hab"  => [$regexCapacite, "Veuillez saisir une capacité valide"],
			];
    foreach($regles as $champ => [$regex, $msg]){
		if(!preg_match($regex, trim($_POST[$champ]))){
			$erreurs[] = $msg;break;
        }
    }

	$nbPhotos = count(array_filter($photos['name']));
	if (($nbPhotos > 0 && $nbPhotos < 3) || $nbPhotos > 3) {
		$erreurs[] = "Veuillez sélectionner exactement 3 photos si vous souhaitez les modifier.";      
    }else{ 
		if($nbPhotos == 3){
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
    }

	if (!empty($erreurs)) {
		$_SESSION['msg-erreurs'] = $erreurs; 
        header("Location:index.php?page=29"); 
        exit; 
    }else{
		$refHab = $unControleur->updateAppartement([
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
            "etage_ap" => $etage_ap,
            "type_ap" => $type_ap,
			"ref_hab" => $ref_hab
		]);

		if($nbPhotos == 3){
			$unControleur->deletePhotos($refHab);
				
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
        }
        $_SESSION['msg-reussite'] = "Mis à jour réussie de l'appartement ✅";
		header("Location:index.php?page=29");
		exit;
	}
}



if(isset($_POST['annuler']) || isset($_POST['effacer'])){
	header("Location:index.php?page=29");
	exit;
}

if(isset($_POST['filtrer'])){
	$filtre = $_POST['filtre'];
	$lesAppartements = $unControleur->selectLikeAppartement($filtre);
}else{
	$lesAppartements = $unControleur->selectAllAppartement();
}

require_once ("vue/vue_appartement.php");
?>


