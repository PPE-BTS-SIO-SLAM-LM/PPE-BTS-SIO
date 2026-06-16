<?php

$lesclients = $unControleur->selectAllClients();
$leClient = null;
$erreurs = [];


if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
	
	if(isset($_GET['action']) && isset($_GET['id_c'])){
		$action = $_GET['action']; 
		$id_c = $_GET['id_c'];

		switch($action){
			case "sup"  : $unControleur->deleteClient($id_c);
						  $_SESSION['msg-reussite'] = "Suppression réussie du client ✅";	
						  header("Location: index.php?page=2");
						  exit;
						  break;
			case "edit" : $leClient = $unControleur->selectWhereIdClient($id_c);break;
		}
	}
}




if(isset($_POST['valider']) || isset($_POST['modifier'])){

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

	$champs = [$nom,$prenom,$email,$mdp,$adresse,$cp,$ville,$tel,$rib];
}
	
	
if(isset($_POST['valider'])){
	
	foreach($champs as $champ){
		if($champ == ""){
			$erreurs[] = "Veuillez remplir touts les champs";break;
        }
    }
	$regles = [
				"nom" => [$regexNom, "Veuillez saisir un nom valide"],
                "prenom" => [$regexPrenom, "Veuillez saisir un prénom valide"],
                "email" => [$regexEmail, "Veuillez saisir un email valide"],
                "mdp" => [$regexMdp, "Veuillez saisir un mot de passe valide"],
                "adresse" => [$regexAdresse, "Veuillez saisir une adresse valide"],
                "cp" => [$regexCp, "Veuillez saisir un code postal valide"],
                "ville" => [$regexVille, "Veuillez saisir un nom de ville valide"],
                "tel" => [$regexTel, "Veuillez saisir un numéro de téléphone valide"],
                "rib" => [$regexRib, "Veuillez saisir un RIB valide"]
			];
    foreach($regles as $champ => [$regex, $msg]){
		if(!preg_match($regex, trim($_POST[$champ]))){
			$erreurs[] = $msg;break;
		}
    }

	if(!empty($erreurs)){
                $_SESSION['msg-erreurs'] = $erreurs;
        }else{
			$unControleur->insertClient($_POST);
			$_SESSION['msg-reussite'] = "Ajout réussi du client ✅";
	}
}
	
	
if(isset($_POST['modifier'])){

	foreach($champs as $champ){
		if($champ == ""){
			$erreurs[] = "Veuillez remplir touts les champs";break;
        }
    }
	$regles = [
				"nom" => [$regexNom, "Veuillez saisir un nom valide"],
                "prenom" => [$regexPrenom, "Veuillez saisir un prénom valide"],
                "email" => [$regexEmail, "Veuillez saisir un email valide"],
                "mdp" => [$regexMdp, "Veuillez saisir un mot de passe valide"],
                "adresse" => [$regexAdresse, "Veuillez saisir une adresse valide"],
                "cp" => [$regexCp, "Veuillez saisir un code postal valide"],
                "ville" => [$regexVille, "Veuillez saisir un nom de ville valide"],
                "tel" => [$regexTel, "Veuillez saisir un numéro de téléphone valide"],
                "rib" => [$regexRib, "Veuillez saisir un RIB valide"]
			];
    foreach($regles as $champ => [$regex, $msg]){
		if(!preg_match($regex, trim($_POST[$champ]))){
			$erreurs[] = $msg;break;
		}
    }

	if(!empty($erreurs)){
            $_SESSION['msg-erreurs'] = $erreurs;
    }else{
		$unControleur->updateClient($_POST);
		$_SESSION['msg-reussite'] = "Modification réussie du client ✅";
		header("Location: index.php?page=2");
		exit;
	}
}


		
if(isset($_POST['annuler']) || isset($_POST['effacer'])){
	header("Location: index.php?page=2");
	exit;
}
if (isset($_POST['filtrer'])){
	$filtre = $_POST['filtre']; 
	$lesClients = $unControleur->selectLikeClient($filtre); 
} else {
		$lesClients = $unControleur->selectAllClients(); 
}

require_once("vue/vue_client.php");
?>
