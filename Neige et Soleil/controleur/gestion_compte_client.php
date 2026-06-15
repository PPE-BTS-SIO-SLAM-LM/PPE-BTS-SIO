<?php 

$id = $_SESSION['id'];

$utilisateur = $unControleur->selectWhereIdUtilisateur($id);
$leClient = $unControleur->selectWhereIdClient($id);


if(isset($_GET['action']) && isset($_GET['ref_res'])){
    $refRes = $_GET['ref_res'];
    $unControleur->annulerReservation($refRes);
    $_SESSION['msg-annul-reservation'] = "Votre réservation a été annulée avec succés✅";
}

$resaClient = $unControleur->selectReservationWhereClient($id);

require_once("vue/vue_compte_client.php");

?>


