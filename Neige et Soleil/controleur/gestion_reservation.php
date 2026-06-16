<script>
	document.addEventListener("DOMContentLoaded", () => {
        const arrivee = document.getElementById('arrivee');
        const depart = document.getElementById('depart');
        const ajd = new Date().toISOString().split('T')[0];
        const demain = new Date(ajd);
        demain.setDate(demain.getDate() + 1);
        arrivee.min = ajd;
		depart.min = demain.toISOString().split('T')[0];

		if(!arrive.value){
			arrivee.value = ajd;	
		}
		if(!depart.value){
			depart.value = demain.toISOString().split('T')[0];
		}
            
        
        arrivee.addEventListener('change', () => {
            depart.min = arrivee.value;  
        });
	})
</script>


<script>
	// On attend que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    const selectHab = document.getElementById('ref_hab');
    const inputCapa = document.getElementById('nb_perso');

    selectHab.addEventListener('change', function() {
        // 'this' représente le select. 
        // options[selectedIndex] permet de cibler précisément l'élément <option> choisi
        const selectedOption = this.options[this.selectedIndex];
        
        // On récupère la valeur de data-capa
        const capacite = selectedOption.getAttribute('capa-max');

        // On l'affiche dans l'input (ou n'importe quel autre élément)
        if (capacite) {
            inputCapa.max = capacite;
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const arrivee = document.getElementById('arrivee');
    const depart = document.getElementById('depart');
    const ajd = new Date().toISOString().split('T')[0];
    const demain = new Date(ajd);
    demain.setDate(demain.getDate() + 1);
    arrivee.min = ajd;
    arrivee.value = ajd;
    depart.min = demain.toISOString().split('T')[0];
    depart.value = demain.toISOString().split('T')[0];
	
	arrivee.addEventListener('change', () => {
    depart.min = arrivee.value;  
    })
});
</script>



<?php
$lesReservations = $unControleur->selectAllReservation();
$lesClients = $unControleur->selectAllClients();
$lesProprietaires = $unControleur->selectAllProprietaire();
$lesHabitations = $unControleur->selectAllHabitation();
$reservation = null;
$habitation = null;
$erreurs = [];

if(isset($_SESSION['email']) && $_SESSION['role']== 'admin'){

	if(isset($_GET['action']) && isset($_GET['ref_res'])){
		$action = $_GET['action'];
		$ref_res = $_GET['ref_res'];

		switch($action){
			case "sup" : $unControleur->annulerReservation($ref_res);
										$_SESSION['msg-reussite'] = "Annulation réussie de la réservation ✅";
										header('Location:index.php?page=5');
										exit;
										break;
			case "edit" : $reservation = $unControleur->selectWhereReservation($ref_res);
							$refHab = $reservation['ref_hab'];
							$habitation = $unControleur->selectWhereHabitation($refHab);
							break;
		}
	}
}


if(isset($_POST['valider']) || isset($_POST['modifier'])){

	$nb_perso = $_POST['nb_perso'];
	$date_debut = $_POST['date_debut'];
	$date_fin = $_POST['date_fin'];
	$etat_res = $_POST['etat_res'];
	$id_c = $_POST['id_c'];
	$ref_hab = $_POST['ref_hab'];

	$champs = [$nb_perso,$date_debut,$date_fin,$etat_res,$id_c,$ref_hab];
}

if(isset($_POST['valider'])){
	foreach($champs as $champ){
		if($champ == ""){
			$erreurs[] = "Veuillez remplir touts les champs";break;
        }
    }
	
	if(!empty($erreurs)){
		$_SESSION['msg-erreurs'] = $erreurs;
    }else{
		$unControleur->insertReservationAdmin($_POST);
		$_SESSION['msg-reussite'] = "Ajout réussie de la reservation ✅";
		header("Location:index.php?page=5");
		exit;
	}
}

if(isset($_POST['modifier'])){
	foreach($champs as $champ){
		if($champ == ""){
			$erreurs[] = "Veuillez remplir touts les champs";break;
        }
    }
	if(!empty($erreurs)){
		$_SESSION['msg-erreurs'] = $erreurs;
    }else{
		$unControleur->updateReservation($_POST);
		$_SESSION['msg-reussite'] = "Mis a jour réussie de la réservation ✅";
		header("Location:index.php?page=5");
		exit;
	}
}

if(isset($_POST['effacer']) || isset($_POST['annuler'])){
	header("Location:index.php?page=5");
	exit;
}

if(isset($_POST['filtrer'])){
	$filtre = $_POST['filtre'];
	$lesReservations = $unControleur->selectLikeReservation($filtre);
}else{
	$lesReservations = $unControleur->selectAllReservation();
}

require_once ("vue/vue_reservation.php");
?>
