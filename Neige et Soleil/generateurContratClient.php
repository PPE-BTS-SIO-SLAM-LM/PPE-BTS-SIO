<?php
session_start();
require_once("./fpdf/fpdf.php");
require_once("controleur/controleur.class.php");


class PDF extends FPDF{
    
    function header(){
        $this->SetFont("Arial","B",12);
        $this->Cell(0,10,"CONTRAT DE RESERVATION",1,1,"C");
    }

    function body(){
        $unControleur = new Controleur();
        
        $id = $_SESSION['id'];
        $leClient = $unControleur->selectWhereIdClient($id);
        $refRes = isset($_GET['ref_res']) ? $_GET['ref_res'] : null;
        $reservationClient = $unControleur->selectWhereReservation($refRes);

        $this->SetFont("Arial","B",12);
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Identité du client (ou de son représentant légal)"),0,1,"C");
        $this->SetFont("Arial","",10);
        $this->MultiCell(0,10,iconv('UTF-8', 'ISO-8859-1',"Nom : ".($leClient['nom']).
                                "\nPrénom : ".($leClient['prenom']).
                                "\nAdresse : ".($leClient['adresse']).
                                "\nCode postal : ".($leClient['cp']).
                                "\nVille : ".($leClient['ville']).
                                "\nE-mail : ".($leClient['email']).
                                "\nTél : ".($leClient['tel']).
                                "\nRIB : ".($leClient['RIB'])),1,"L");
        $this->SetFont("Arial","B",12);
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Réservation"),0,1,"C");

        if (!empty($reservationClient)) {
                $this->SetFont("Arial","",10);
                $this->MultiCell(0,10,iconv('UTF-8', 'ISO-8859-1',"Référence : ".($reservationClient['ref_res']).
                                "\nIdentifant habitation : ".($reservationClient['ref_hab']).
                                "\nDate réservation : ".($reservationClient['date_res']).
                                "\nNombre personnes : ".($reservationClient['nb_perso']).
                                "\nDate début : ".($reservationClient['date_debut']).
                                "\nDate fin : ".($reservationClient['date_fin']).
                                "\nMontant total : ".($reservationClient['prix_a_payer'])).chr(128),1,"L");
            }else {
                $this->SetFont("Arial","",10);
                $this->Cell(0, 10,iconv('UTF-8','ISO-8859-1', "Aucune information trouvée pour la réservation : " . $refRes), 1, 1);
            } 
          
    }

    function footer(){
        $this->SetFont("Arial","B",12);
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Signature des deux parties"),0,1,"C");
        $this->SetFont("Arial","",10);
        $this->Cell(0,30,iconv('UTF-8', 'ISO-8859-1',"Le Client"),1,1,"L");
        $this->Cell(0,30,iconv('UTF-8', 'ISO-8859-1',"Neige & Soleil"),1,1,"L");
    }
    
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->body();
$pdf->Output();
?>