<?php
session_start();
require_once("./fpdf/fpdf.php");
require_once("controleur/controleur.class.php");



class PDF extends FPDF{
    
    function header(){
        $this->SetFont("Arial","B",12);
        $this->Cell(0,10,"CONTRAT DE MANDAT LOCATIF",1,1,"C");
    }

    function body(){
        $unControleur = new Controleur();
            
        $refHab = isset($_GET['ref_hab']) ? $_GET['ref_hab'] : null;

        $maison = $unControleur->selectWhereMaison($refHab);
        $appartement = $unControleur->selectWhereAppartement($refHab);
        $id = $_SESSION['id'];
        $leProprietaire = $unControleur->selectWhereIdProprietaire($id);

        $this->SetFont("Arial","B",12);
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Identité du propriétaire (ou de son représentant légal)"),0,1,"C");
        $this->SetFont("Arial","",10);
        $this->MultiCell(0,10,iconv('UTF-8', 'ISO-8859-1',"Nom : ".($leProprietaire['nom']).
                                "\nPrenom : ".($leProprietaire['prenom']).
                                "\nAdresse : ".($leProprietaire['adresse']).
                                "\nCode postal : ".($leProprietaire['cp']).
                                "\nVille : ".($leProprietaire['ville']).
                                "\nE-mail : ".($leProprietaire['email']).
                                "\nTél : ".($leProprietaire['tel']).
                                "\nRIB : ".($leProprietaire['RIB'])
                                ),1,"L");
        $this->SetFont("Arial","B",12);
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Informations habitation"),0,1,"C");

        if (!empty($maison)) {
                $this->SetFont("Arial","",10);
                $this->MultiCell(0,10,iconv('UTF-8', 'CP1252',"Type : ".($maison['type_hab']).
                                "\nAdresse : ".($maison['adr_hab']).
                                "\nCode postal : ".($maison['cp_hab']).
                                "\nVille : ".($maison['ville_hab']).
                                "\nMontant de location hebdomadaire saison basse : ".($maison['tarif_hab_bas'])."€".
                                "\nMontant de location hebdomadaire saison moyenne : ".($maison['tarif_hab_moy'])."€".
                                "\nMontant de location hebdomadaire saison haute : ".($maison['tarif_hab_hau'])."€".
                                "\nSurface : ".($maison['surface']."m2").
                                "\nCapacité : ".($maison['capacite_hab'])." personnes".
                                "\nCaractéristiques : ".($maison['carac_m'])),1,"L");       
        }
        elseif (!empty($appartement)) {
                $this->SetFont("Arial","",10);
                $this->MultiCell(0,10,iconv('UTF-8', 'CP1252',"Type : ".($appartement['type_hab']).
                                "\nAdresse : ".($appartement['adr_hab']).
                                "\nCode postal : ".($appartement['cp_hab']).
                                "\nVille : ".($appartement['ville_hab']).
                                "\nMontant de location hebdomadaire saison basse : ".($appartement['tarif_hab_bas'])."€".
                                "\nMontant de location hebdomadaire saison moyenne : ".($appartement['tarif_hab_moy'])."€".
                                "\nMontant de location hebdomadaire saison haute : ".($appartement['tarif_hab_hau'])."€".
                                "\nSurface : ".($appartement['surface']."m2").
                                "\nCapacité : ".($appartement['capacite_hab'])." personnes".
                                "\nEtage : ".($appartement['etage_ap']).
                                "\nType d'appartement : ".($appartement['type_ap'])),1,"L");
        } 
        else {
            $this->SetFont("Arial","",10);
            $this->Cell(0, 10, "Aucune information trouvee pour l'habitation ref : " . $refHab, 1, 1);
        } 
    }

    function footer(){
        $this->SetFont("Arial","B",12);
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Signature des deux parties"),0,1,"C");
        $this->SetFont("Arial","",10);
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Propriétaire"),1,1,"L");
        $this->Cell(0,15,iconv('UTF-8', 'ISO-8859-1',"Neige & Soleil"),1,1,"L");
    }
    
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->body();
$pdf->Output();
?>