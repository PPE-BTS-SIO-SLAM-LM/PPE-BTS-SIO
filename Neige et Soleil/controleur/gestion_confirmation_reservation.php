<?php
    if(!isset($_SESSION['reservation'])){
        header("Location: index.php?page=1");
        exit;
    }

    $data = $_SESSION['reservation'];

    if(isset($_POST['confirmer'])){
        $unControleur->insertReservation($_POST);
        header("Location: index.php?page=12");
        exit;
    }

    if(isset($_POST['annuler'])){
        $refHab = $_POST['ref_hab'];

        header("Location:index.php?page=10&ref_hab=".$refHab);
        exit; 
    }

    require_once("vue/vue_confirmation_reservation.php");
?>
