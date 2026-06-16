<?php
require_once("modele/modele.class.php");

class Controleur {
    private $unModele ;

    public function __construct (){
        $this->unModele= new Modele();
    }

    
    
    
    /******************************************************     UTILISATEURS     ******************************************************/
    public function selectAllUtilisateurs(){
        return $this->unModele->selectAllUtilisateurs();
    }
    public function selectWhereUtilisateur($email,$mdp){
        return $this->unModele->selectWhereUtilisateur($email,$mdp);
    }
    public function selectWhereIdUtilisateur($id){
        return $this->unModele->selectWhereIdUtilisateur($id);
    }

    public function selectWhereEmailUtilisateur($email){
        return $this->unModele->selectWhereEmailUtilisateur($email);
    }


    
    
    /******************************************************     CLIENTS     ******************************************************/
    public function insertClient($tab){
        $this->unModele->insertClient($tab);
    }
    public function selectAllClients(){
        return $this->unModele->selectAllClients();
    }
    public function selectLikeClient($filtre){
    return $this->unModele->selectLikeClient($filtre);
    }
    public function deleteClient($id_c){
        $this->unModele->deleteClient($id_c);
    }
    public function selectWhereIdClient($id_c){
    return $this->unModele->selectWhereIdClient($id_c);
    }
    public function updateClient($id_c) {
        $_POST['id_c'] = $id_c;
        return $this->unModele->updateClient($_POST);
    }   


    
    
    /******************************************************     PROPRIOS    ******************************************************/
    public function insertProprietaire($tab){
        $this->unModele->insertProprietaire($tab);
    }
    public function selectAllProprietaire(){
        return $this->unModele->selectAllProprietaire();
    }
    public function selectLikeProprietaire($filtre){
         return $this->unModele->selectLikeProprietaire($filtre);
    }
    public function deleteProprietaire($id_p){
        $this->unModele->deleteProprietaire($id_p);
    }
    public function selectWhereIdProprietaire($id_p){
         return $this->unModele->selectWhereIdProprietaire($id_p);
    }
    //public function selectWhereProprietaire($email, $mdp){
        //controler l'email et le mdp
        // return $this->unModele->selectWhereProprietaire($email, $mdp);
    //}
    public function updateProprietaire($id_p){
        $_POST['id_p'] = $id_p;
        $this->unModele->updateProprietaire($_POST);
    }


    
    
    /******************************************************     HABITATIONS     ******************************************************/
    public function insertHabitation($tab){
        //controle des donnees du clients
        //appel du modele pour realiser l'insertion
       return $this->unModele->insertHabitation($tab);
    }
    public function selectAllHabitation(){
        return $this->unModele->selectAllHabitation();
    }
    public function selectAllHabitationType($type){
        return $this->unModele->selectAllHabitationType($type);
    }
    public function selectAllHabitationTypePrixMin($type,$prixMin){
        return $this->unModele->selectAllHabitationTypePrixMin($type,$prixMin);
    }
    public function selectAllHabitationTypePrixMax($type,$prixMax){
        return $this->unModele->selectAllHabitationTypePrixMax($type,$prixMax);
    }
    public function selectAllHabitationTypePrixMinMax($type,$prixMin,$prixMax){
        return $this->unModele->selectAllHabitationTypePrixMinPrixMax($type,$prixMin,$prixMax);
    }
    public function selectAllHabitationPrixMin($prixMin){
        return $this->unModele->selectAllHabitationPrixMin($prixMin);
    }
    public function selectAllHabitationPrixMax($prixMax){
        return $this->unModele->selectAllHabitationPrixMax($prixMax);
    }
    public function selectAllHabitationPrixMinMax($prixMin,$prixMax){
        return $this->unModele->selectAllHabitationPrixMinPrixMax($prixMin,$prixMax);
    }
    public function selectLikeHabitation($filtre){
    return $this->unModele->selectLikeHabitation($filtre);
    }
    public function deleteHabitation($ref_hab){
        $this->unModele->deleteHabitation($ref_hab);
    }
    public function selectWhereHabitation($ref_hab){
    return $this->unModele->selectWhereHabitation($ref_hab);
    }
    public function selectHabitationWhereProprietaire($id_p){
        return $this->unModele->selectHabitationWhereProprietaire($id_p);
    }
    public function updateHabitation($tab) {
        return $this->unModele->updateHabitation($tab);
    }
    public function updateHabitationAnnonce($tab) {
        $this->unModele->updateHabitationAnnonce($tab);
    }


    
    
    /******************************************************     MAISONS     ******************************************************/
    public function selectAllMaison(){
        return $this->unModele->selectAllMaison();
    }
    public function selectWhereMaison($ref_hab){
        return $this->unModele->selectWhereMaison($ref_hab);
    }
    public function insertMaison($tab){
        return $this->unModele->insertMaison($tab);
    }
    public function deleteMaison($ref_hab){
        return $this->unModele->deleteMaison($ref_hab);
    }
    public function updateMaisonAnnonce($tab){
        $this->unModele->updateMaisonAnnonce($tab);
    }
    public function updateMaison($tab){
        $this->unModele->updateMaison($tab);
    }
    public function selectLikeMaison($filtre){
        $this->unModele->selectLikeMaison($filtre);
    }
    

    
    
    /******************************************************     APPARTEMENTS     ******************************************************/
    public function selectAllAppartement(){
        return $this->unModele->selectAllAppartement();
    }
    public function selectWhereAppartement($ref_hab){
        return $this->unModele->selectWhereAppartement($ref_hab);
    }
    public function insertAppartement($tab){
        return $this->unModele->insertAppartement($tab);
    }
    public function deleteAppartement($ref_hab){
        return $this->unModele->deleteAppartement($ref_hab);
    }
    public function updateAppartementAnnonce($tab){
        $this->unModele->updateAppartementAnnonce($tab);
    }
    public function updateAppartement($tab){
        $this->unModele->updateAppartement($tab);
    }
    public function selectLikeAppartement($filtre){
        $this->unModele->selectLikeAppartement($filtre);
    }

    
    
    
    /******************************************************     RESERVATIONS     ******************************************************/
    public function insertReservation($tab){
        //controle des donnees du clients

        //appel du modele pour realiser l'insertion
        $this->unModele->insertReservation($tab);
    }
    public function insertReservationAdmin($tab){
        //controle des donnees du clients

        //appel du modele pour realiser l'insertion
        $this->unModele->insertReservationAdmin($tab);
    }
    public function selectAllReservation(){
        return $this->unModele->selectAllReservation();
    }
    public function selectLikeReservation($filtre){
    return $this->unModele->selectLikeReservation($filtre);
    }
    public function deleteReservation($ref_res){
        $this->unModele->deleteReservation($ref_res);
    }
    public function selectWhereReservation($ref_res){
    return $this->unModele->selectWhereReservation($ref_res);
    }
    public function selectReservationWhereClient($id_c){
        return $this->unModele->selectReservationWhereClient($id_c);
    }
    public function updateReservation($tab) {
        $this->unModele->updateReservation($tab);
    }
    public function selectCountReservationValidee(){
        return $this->unModele->selectCountReservationValidee();
    }
    public function annulerReservation($ref_res){
        $this->unModele->annulerReservation($ref_res);
    }




    /******************************************************     ADMINS     ******************************************************/
    public function selectWhereAdmin($email,$mdp){
        return $this->unModele->selectWhereAdmin($email,$mdp);
    }




    /******************************************************     PHOTOS     ******************************************************/
    public function selectAllPhotoPrincipal(){
        return $this->unModele->selectAllPhotoPrincipal();
    }
    public function selectAllPhotosWhere($refHab){
        return $this->unModele->selectAllPhotosWhere($refHab);
    }
    public function selectPhotoPrincipalHabitation($refHab){
        return $this->unModele->selectPhotoPrincipalHabitation($refHab);
    }
    public function insertPhoto($tab){
        $this->unModele->insertPhoto($tab);
    }
    public function deletePhotos($refHab){
        $this->unModele->deletePhotos($refHab);
    }




    /******************************************************     CONTRATS     ******************************************************/
    public function selectCountContratByProprio(){
        return $this->unModele->selectCountContratByProprio();
    }


    
    
    /******************************************************     REINITIALISATION MDP     ******************************************************/
    public function verifCode($email,$mdp){
        return $this->unModele->verifCode($email,$mdp);
    }
    public function resetCode($email,$mdp){
        $this->unModele->resetCode($email,$mdp);
    }
    public function updateMdp($email,$newMdp){
        $this->unModele->updateMdp($email,$newMdp);
    }
    public function changerMdp($email,$nvMdp){
        $this->unModele->changerMdp($email,$nvMdp);
    }
}