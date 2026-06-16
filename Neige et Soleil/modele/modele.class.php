<?php 

class Modele{
    private $unPdo;

    public function __construct(){
        $url = "mysql:host=localhost;dbname=neigeetsoleil";
        $user = "root";
        $mdp = "";

        try {
            $this->unPdo = new PDO($url,$user,$mdp);
            $this->unPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "connexion a la base de données impossible";
            echo $e->getMessage();
        }
    }



    
    /******************************************************     UTILISATEURS     ******************************************************/
    public function selectAllUtilisateurs(){
        $requete = "SELECT * FROM utilisateur;";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }
    public function selectWhereUtilisateur($email,$mdp){
        $requete = "SELECT * FROM utilisateur where email = :email and mdp = :mdp;";
        $data = array(":email"=>$email,":mdp"=>$mdp);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function selectWhereEmailUtilisateur($email){
        $requete = "SELECT * FROM utilisateur where email = :email;";
        $data = array(":email"=>$email);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function selectWhereIdUtilisateur($id){
        $requete = "SELECT * FROM utilisateur where id_user = :id";
        $data = array(":id"=>$id);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function insertUtilisateur($tab){
        $requete = "INSERT INTO utilisateur (nom,prenom,email,mdp,tel,role) VALUES (:nom,:prenom,:email,:mdp,:tel,:role);";
        $data = array(":nom"=>$tab['nom'],":prenom"=>$tab['prenom'],":email"=>$tab['email'],":mdp"=>$tab['mdp'],":tel"=>$tab['tel'],":role"=>$tab['role']);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $this->unPdo->lastInsertId();
    }




    /******************************************************     CLIENTS    ******************************************************/
    public function insertClient($tab) {
        try {
            $this->unPdo->beginTransaction();

            $reqUser= "INSERT INTO utilisateur (nom, prenom, email, mdp, tel, role) 
                       VALUES (:nom, :prenom, :email, :mdp, :tel, 'client')";
            $stmtUser = $this->unPdo->prepare($reqUser);
            $stmtUser->execute([
                ":nom" => $tab['nom'],
                ":prenom" => $tab['prenom'],
                ":email" => $tab['email'],
                ":mdp" => $tab['mdp'],
                ":tel" => $tab['tel']
            ]);

            $lastId = $this->unPdo->lastInsertId();

            $reqClient = "INSERT INTO client (id_c, adresse, cp, ville, RIB) 
                          VALUES (:id, :adresse, :cp, :ville, :rib)";
            $stmtClient = $this->unPdo->prepare($reqClient);
            $stmtClient->execute([
                ":id" => $lastId,
                ":adresse" => $tab['adresse'],
                ":cp" => $tab['cp'],
                ":ville" => $tab['ville'],
                ":rib" => $tab['rib']
            ]);

            $this->unPdo->commit();
            return $lastId;

        } catch (Exception $e) {
            $this->unPdo->rollBack(); 
            echo $e->getMessage();
            die;
        }
    }

    public function updateClient($tab) {
        try {
            $this->unPdo->beginTransaction();

            $reqUser= "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email,
                       mdp = :mdp, tel = :tel WHERE id_user = :id_user;";
            $stmtUser = $this->unPdo->prepare($reqUser);
            $stmtUser->execute([
                ":nom" => $tab['nom'],
                ":prenom" => $tab['prenom'],
                ":email" => $tab['email'],
                ":mdp" => $tab['mdp'],
                ":tel" => $tab['tel'],
                ":id_user" => $tab['id_user']
            ]);

            $reqClient = "UPDATE client SET adresse = :adresse, cp = :cp, ville = :ville,
                         RIB = :rib WHERE id_c = :id_c;";
            $stmtClient = $this->unPdo->prepare($reqClient);
            $stmtClient->execute([
                ":adresse" => $tab['adresse'],
                ":cp" => $tab['cp'],
                ":ville" => $tab['ville'],
                ":rib" => $tab['rib'],
                ":id_c" => $tab['id_user']
            ]);

            $this->unPdo->commit();

        } catch (Exception $e) {
            $this->unPdo->rollBack(); 
            echo $e->getMessage();
            die;
        }
    }

    public function selectAllClients() {
        $requete = "SELECT * FROM utilisateur U
                    INNER JOIN client C ON U.id_user = C.id_c
                    ORDER BY C.id_c ASC";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }
    public function selectWhereIdClient($id) {
        $requete = "SELECT * FROM utilisateur U
                    INNER JOIN client C ON U.id_user = C.id_c
                    WHERE U.id_user = :id;";
        $data = array(":id"=>$id);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function deleteClient($id) {
        $requete = "DELETE FROM utilisateur WHERE id_user = :id;";
        $data = array(":id"=>$id);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function selectLikeClient($filtre) {
        $requete = "SELECT * FROM utilisateur U
                    INNER JOIN client C ON U.id_user = C.id_c
                    WHERE U.nom LIKE :filtre 
                    OR U.prenom LIKE :filtre 
                    OR C.ville LIKE :filtre
                    OR C.cp LIKE :filtre;";
        $data = array(":filtre" => "%" . $filtre . "%");  
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }




    /******************************************************     PROPRIOS     ******************************************************/ 
    public function insertProprietaire($tab) {
        try {
            $this->unPdo->beginTransaction();

            $reqUser= "INSERT INTO utilisateur (nom, prenom, email, mdp, tel, role) 
                       VALUES (:nom, :prenom, :email, :mdp, :tel, 'proprietaire')";
            $stmtUser = $this->unPdo->prepare($reqUser);
            $stmtUser->execute([
                ":nom" => $tab['nom'],
                ":prenom" => $tab['prenom'],
                ":email" => $tab['email'],
                ":mdp" => $tab['mdp'],
                ":tel" => $tab['tel']
            ]);

            $lastId = $this->unPdo->lastInsertId();

            $reqProprio = "INSERT INTO proprietaire (id_p, adresse, cp, ville, RIB) 
                          VALUES (:id, :adresse, :cp, :ville, :rib)";
            $stmtProprio = $this->unPdo->prepare($reqProprio);
            $stmtProprio->execute([
                ":id" => $lastId,
                ":adresse" => $tab['adresse'],
                ":cp" => $tab['cp'],
                ":ville" => $tab['ville'],
                ":rib" => $tab['rib']
            ]);

            $this->unPdo->commit();
            return $lastId;

        } catch (Exception $e) {
            $this->unPdo->rollBack(); 
            return null;
        }
    }
    
    public function updateProprietaire($tab) {
        try {
            $this->unPdo->beginTransaction();

            $reqUser= "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email,
                       mdp = :mdp, tel = :tel WHERE id_user = :id_user;";
            $stmtUser = $this->unPdo->prepare($reqUser);
            $stmtUser->execute([
                ":nom" => $tab['nom'],
                ":prenom" => $tab['prenom'],
                ":email" => $tab['email'],
                ":mdp" => $tab['mdp'],
                ":tel" => $tab['tel'],
                ":id_user" => $tab['id_user']
            ]);

            $reqProprio = "UPDATE proprietaire SET adresse = :adresse, cp = :cp, 
                          ville = :ville, RIB = :rib WHERE id_p = :id_p;";
            $stmtProprio = $this->unPdo->prepare($reqProprio);
            $stmtProprio->execute([
                ":adresse" => $tab['adresse'],
                ":cp" => $tab['cp'],
                ":ville" => $tab['ville'],
                ":rib" => $tab['rib'],
                ":id_p" => $tab['id_user']
            ]);

            $this->unPdo->commit();

        } catch (Exception $e) {
            $this->unPdo->rollBack(); 
            echo $e->getMessage();
            die;
        }
    }

    public function selectAllProprietaire() {
        $requete = "SELECT * FROM utilisateur U
                    INNER JOIN proprietaire P ON U.id_user = P.id_p
                    ORDER BY P.id_p ASC";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }
    public function selectWhereIdProprietaire($id) {
        $requete = "SELECT * FROM utilisateur U
                    INNER JOIN proprietaire P ON U.id_user = P.id_p
                    WHERE U.id_user = :id;";
        $data = array(":id"=>$id);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function deleteProprietaire($id) {
        $requete = "DELETE FROM utilisateur WHERE id_user = :id;";
        $data = array(":id"=>$id);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function selectLikeProprietaire($filtre) {
        $requete = "SELECT * FROM utilisateur U
                    INNER JOIN proprietaire P ON U.id_user = P.id_p
                    WHERE U.nom LIKE :filtre 
                    OR U.prenom LIKE :filtre 
                    OR P.ville LIKE :filtre
                    OR P.cp LIKE :filtre;";
        $data = array(":filtre" => "%" . $filtre . "%");  
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }



    
    /******************************************************     HABITATIONS     ******************************************************/
    public function selectAllHabitation(){
        $requete = "SELECT * FROM habitation;";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }
    public function selectWhereHabitation($ref_hab){
        $requete = "SELECT * FROM habitation where ref_hab = :ref_hab;";
        $data = array(":ref_hab"=>$ref_hab);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function selectAllHabitationType($type){
        $requete = "SELECT * FROM habitation where type_hab = :type_hab;";
        $data = array(":type_hab"=>$type);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectAllHabitationTypePrixMin($type,$prixMin){
        $requete = "SELECT * FROM habitation WHERE type_hab = :type_hab AND tarif_hab_moy >= :prixMin;";
        $data = array(":type_hab"=>$type, ":prixMin"=>$prixMin);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectAllHabitationTypePrixMax($type,$prixMax){
        $requete = "SELECT * FROM habitation WHERE type_hab = :type_hab AND tarif_hab_moy <= :prixMax;";
        $data = array(":type_hab"=>$type, ":prixMax"=>$prixMax);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectAllHabitationTypePrixMinPrixMax($type,$prixMin,$prixMax){
        $requete = "SELECT * FROM habitation WHERE type_hab = :type_hab AND tarif_hab_moy BETWEEN :prixMin AND :prixMax;";
        $data = array(":type_hab"=>$type, ":prixMin"=>$prixMin, ":prixMax"=>$prixMax);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectAllHabitationPrixMin($prixMin){
        $requete = "SELECT * FROM habitation where tarif_hab_moy >= :prixMin;";
        $data = array(":prixMin"=>$prixMin);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectAllHabitationPrixMax($prixMax){
        $requete = "SELECT * FROM habitation where tarif_hab_moy <= :prixMax;";
        $data = array(":prixMax"=>$prixMax);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectAllHabitationPrixMinPrixMax($prixMin, $prixMax){
        $requete = "SELECT * FROM habitation where tarif_hab_moy between :prixMin and :prixMax;";
        $data = array(":prixMin"=>$prixMin, ":prixMax"=>$prixMax);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectHabitationWhereProprietaire($id_p){
        $requete = "SELECT * FROM habitation WHERE id_p = :id_p;";
        $data = array(":id_p"=>$id_p);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function insertHabitation($tab){
        $requete = "INSERT INTO habitation
                        (type_hab, adr_hab, cp_hab, ville_hab, tarif_hab_bas, tarif_hab_moy, 
                        tarif_hab_hau, surface, id_p, description_hab, titre_hab, 
                        capacite_hab)
                    VALUES (:type_hab,:adr_hab,:cp_hab,:ville_hab,:tarif_hab_bas,
                            :tarif_hab_moy,:tarif_hab_hau,:surface,:id_p,:description_hab,
                            :titre_hab,:capacite_hab);";
        $exe = $this->unPdo->prepare($requete);
        $data = array(
            ":type_hab"=>$tab['type_hab'],
            ":adr_hab"=>$tab['adr_hab'],
            ":cp_hab"=>$tab['cp_hab'],
            ":ville_hab"=>$tab['ville_hab'],
            ":tarif_hab_bas"=>$tab['tarif_hab_bas'],
            ":tarif_hab_moy"=>$tab['tarif_hab_moy'],
            ":tarif_hab_hau"=>$tab['tarif_hab_hau'],
            ":surface"=>$tab['surface'],
            ":id_p"=>$tab['id_p'],
            ":description_hab"=>$tab['description_hab'],
            ":titre_hab"=>$tab['titre_hab'],
            ":capacite_hab"=>$tab['capacite_hab']
            );
        $exe->execute($data);
        return $this->unPdo->lastInsertId();
    }
    public function updateHabitation($tab){
        $requete = "UPDATE habitation SET type_hab = :type_hab, adr_hab = :adr_hab, cp_hab = :cp_hab, ville_hab = :ville_hab, tarif_hab_bas = :tarif_hab_bas, tarif_hab_moy = :tarif_hab_moy, tarif_hab_hau = :tarif_hab_hau, surface = :surface, id_p = :id_p, description_hab = :description_hab, titre_hab = :titre_hab, capacite_hab = :capacite_hab where ref_hab = :ref_hab;";
        $data = array(":type_hab"=>$tab['type_hab'],":adr_hab"=>$tab['adr_hab'],":cp_hab"=>$tab['cp_hab'],":ville_hab"=>$tab['ville_hab'],":tarif_hab_bas"=>$tab['tarif_hab_bas'],":tarif_hab_moy"=>$tab['tarif_hab_moy'],":tarif_hab_hau"=>$tab['tarif_hab_hau'],":surface"=>$tab['surface'],":id_p"=>$tab['id_p'],":description_hab"=>$tab['description_hab'],":titre_hab"=>$tab['titre_hab'],":capacite_hab"=>$tab['capacite_hab'],":ref_hab"=>$tab['ref_hab']);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function updateHabitationAnnonce($tab){
        $requete = "UPDATE habitation SET tarif_hab_bas = :tarif_hab_bas, tarif_hab_moy = :tarif_hab_moy, tarif_hab_hau = :tarif_hab_hau, description_hab = :description_hab, titre_hab = :titre_hab, capacite_hab = :capacite_hab WHERE ref_hab = :ref_hab;";
        $data = array(":tarif_hab_bas"=>$tab['tarif_hab_bas'],
                      ":tarif_hab_moy"=>$tab['tarif_hab_moy'],
                      ":tarif_hab_hau"=>$tab['tarif_hab_hau'],
                      ":description_hab"=>$tab['description_hab'],
                      ":titre_hab"=>$tab['titre_hab'],
                      ":capacite_hab"=>$tab['capacite_hab'],
                      ":ref_hab"=>$tab['ref_hab']
                      );
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function deleteHabitation($ref_hab){
        $requete = "DELETE FROM habitation where ref_hab = :ref_hab;";
        $exe = $this->unPdo->prepare($requete);
        $data = array(":ref_hab"=>$ref_hab);
        $exe->execute($data);    
    }
    public function selectLikeHabitation($filtre){
        $requete = "select * from habitation where type_hab like :filtre or adr_hab like :filtre or cp_hab like :filtre or ville_hab like :filtre or tarif_hab_bas like :filtre or tarif_hab_moy like :filtre or tarif_hab_hau like :filtre or surface like :filtre;";
        $data = array(":filtre"=>"%".$filtre."%");
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }




    /******************************************************     MAISONS     ******************************************************/
    public function selectAllMaison(){
        $requete = "SELECT * FROM maison;";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }

    public function insertMaison($tab) {
        $requete = "INSERT INTO maison (type_hab, adr_hab, cp_hab, ville_hab, tarif_hab_bas, tarif_hab_moy, tarif_hab_hau, surface, id_p, description_hab, titre_hab, capacite_hab, carac_m) 
                VALUES ('Maison', :adr_hab, :cp_hab, :ville_hab, :tarif_hab_bas, :tarif_hab_moy, :tarif_hab_hau, :surface, :id_p, :description_hab, :titre_hab, :capacite_hab, :carac_m);";
        
        $exe = $this->unPdo->prepare($requete);

        $exe->execute([
            ":adr_hab" => $tab['adr_hab'],
            ":cp_hab" => $tab['cp_hab'],
            ":ville_hab" => $tab['ville_hab'],
            ":tarif_hab_bas" => $tab['tarif_hab_bas'],
            ":tarif_hab_moy" => $tab['tarif_hab_moy'],
            ":tarif_hab_hau" => $tab['tarif_hab_hau'],
            ":surface" => $tab['surface'],
            ":id_p" => $tab['id_p'],
            ":description_hab" => $tab['description_hab'],
            ":titre_hab" => $tab['titre_hab'],
            ":capacite_hab" => $tab['capacite_hab'],
            ":carac_m" => $tab['carac_m']
        ]);

        $requeteId = "SELECT MAX(ref_hab) as dernier_id FROM habitation";
        $exeId = $this->unPdo->prepare($requeteId);
        $exeId->execute();
        $resultat = $exeId->fetch();

        return $resultat['dernier_id'];
    }

    public function updateMaison($tab){
        $requete = "UPDATE maison SET adr_hab = :adr_hab, cp_hab = :cp_hab, ville_hab = :ville_hab, 
            tarif_hab_bas = :tarif_hab_bas, tarif_hab_moy = :tarif_hab_moy, tarif_hab_hau = :tarif_hab_hau, 
            surface = :surface, id_p = :id_p, description_hab = :description_hab, titre_hab = :titre_hab, 
            capacite_hab = :capacite_hab, carac_m = :carac_m where ref_hab = :ref_hab;";

        $data = array(
                        ":adr_hab"=>$tab['adr_hab'],
                        ":cp_hab"=>$tab['cp_hab'],
                        ":ville_hab"=>$tab['ville_hab'],
                        ":tarif_hab_bas"=>$tab['tarif_hab_bas'],
                        ":tarif_hab_moy"=>$tab['tarif_hab_moy'],
                        ":tarif_hab_hau"=>$tab['tarif_hab_hau'],
                        ":surface"=>$tab['surface'],
                        ":id_p"=>$tab['id_p'],
                        ":description_hab"=>$tab['description_hab'],
                        ":titre_hab"=>$tab['titre_hab'],
                        ":capacite_hab"=>$tab['capacite_hab'],
                        "carac_m"=>$tab['carac_m'],
                        ":ref_hab"=>$tab['ref_hab']
                    );

        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }

    public function selectWhereMaison($ref_hab){
        $requete = "SELECT * FROM maison WHERE ref_hab = :ref_hab;";
        $data = array(":ref_hab"=>$ref_hab);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function deleteMaison($ref_hab){
        $requete = "UPDATE contrat SET status_c = 'Annule' where ref_hab = :ref_hab";
        $data = array(":ref_hab"=>$ref_hab);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);

        $requete = "DELETE FROM maison where ref_hab = :ref_hab;";
        $exe = $this->unPdo->prepare($requete);
        $data = array(":ref_hab"=>$ref_hab);
        $exe->execute($data); 
    }
    public function updateMaisonAnnonce($tab){
        $requete = "UPDATE maison SET tarif_hab_bas = :tarif_hab_bas, tarif_hab_moy = :tarif_hab_moy, tarif_hab_hau = :tarif_hab_hau, description_hab = :description_hab, titre_hab = :titre_hab, capacite_hab = :capacite_hab, carac_m = :carac_m WHERE ref_hab = :ref_hab;";
        $data = array(":tarif_hab_bas"=>$tab['tarif_hab_bas'],
                      ":tarif_hab_moy"=>$tab['tarif_hab_moy'],
                      ":tarif_hab_hau"=>$tab['tarif_hab_hau'],
                      ":description_hab"=>$tab['description_hab'],
                      ":titre_hab"=>$tab['titre_hab'],
                      ":capacite_hab"=>$tab['capacite_hab'],
                      ":carac_m"=>$tab['carac_m'],
                      ":ref_hab"=>$tab['ref_hab']
                      );
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function selectLikeMaison($filtre){
        $requete = "select * from maison where type_hab like :filtre or adr_hab like :filtre or cp_hab like :filtre or ville_hab like :filtre or tarif_hab_bas like :filtre or tarif_hab_moy like :filtre or tarif_hab_hau like :filtre or surface like :filtre or ;";
        $data = array(":filtre"=>"%".$filtre."%");
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }




    /******************************************************     APPARTEMENTS     ******************************************************/
    public function selectAllAppartement(){
        $requete = "SELECT * FROM appartement;";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }

    public function insertAppartement($tab){
        $requete = "INSERT INTO appartement
                        (type_hab, adr_hab, cp_hab, ville_hab, tarif_hab_bas, tarif_hab_moy, 
                        tarif_hab_hau, surface, id_p, description_hab, titre_hab, 
                        capacite_hab,etage_ap,type_ap)
                    VALUES ('Appartement',:adr_hab,:cp_hab,:ville_hab,:tarif_hab_bas,
                            :tarif_hab_moy,:tarif_hab_hau,:surface,:id_p,:description_hab,
                            :titre_hab,:capacite_hab,:etage_ap,:type_ap);";

        $exe = $this->unPdo->prepare($requete);

        $exe->execute([
            ":adr_hab"=>$tab['adr_hab'],
            ":cp_hab"=>$tab['cp_hab'],
            ":ville_hab"=>$tab['ville_hab'],
            ":tarif_hab_bas"=>$tab['tarif_hab_bas'],
            ":tarif_hab_moy"=>$tab['tarif_hab_moy'],
            ":tarif_hab_hau"=>$tab['tarif_hab_hau'],
            ":surface"=>$tab['surface'],
            ":id_p"=>$tab['id_p'],
            ":description_hab"=>$tab['description_hab'],
            ":titre_hab"=>$tab['titre_hab'],
            ":capacite_hab"=>$tab['capacite_hab'],
            ":etage_ap"=>$tab['etage_ap'],
            "type_ap"=>$tab['type_ap']
            ]);

            $requeteId = "SELECT MAX(ref_hab) as dernier_id FROM habitation";
            $exeId = $this->unPdo->prepare($requeteId);
            $exeId->execute();
            $resultat = $exeId->fetch();

            return $resultat['dernier_id'];
        }
    
        public function updateAppartement($tab){
        $requete = "UPDATE appartement SET adr_hab = :adr_hab, cp_hab = :cp_hab, ville_hab = :ville_hab, 
            tarif_hab_bas = :tarif_hab_bas, tarif_hab_moy = :tarif_hab_moy, tarif_hab_hau = :tarif_hab_hau, surface = :surface, 
            id_p = :id_p, description_hab = :description_hab, titre_hab = :titre_hab, capacite_hab = :capacite_hab, etage_ap = :etage_ap,
            type_ap = :etage_ap where ref_hab = :ref_hab;";

        $data = array(
                        ":adr_hab"=>$tab['adr_hab'],
                        ":cp_hab"=>$tab['cp_hab'],
                        ":ville_hab"=>$tab['ville_hab'],
                        ":tarif_hab_bas"=>$tab['tarif_hab_bas'],
                        ":tarif_hab_moy"=>$tab['tarif_hab_moy'],
                        ":tarif_hab_hau"=>$tab['tarif_hab_hau'],
                        ":surface"=>$tab['surface'],":id_p"=>$tab['id_p'],
                        ":description_hab"=>$tab['description_hab'],
                        ":titre_hab"=>$tab['titre_hab'],
                        ":capacite_hab"=>$tab['capacite_hab'],
                        ":etage_ap"=>$tab['etage_ap'],
                        ":type_ap"=>$tab['type_ap'],
                        ":ref_hab"=>$tab['ref_hab']
                    );

        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    
    public function selectWhereAppartement($ref_hab){
        $requete = "SELECT * FROM appartement WHERE ref_hab = :ref_hab;";
        $data = array(":ref_hab"=>$ref_hab);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function deleteAppartement($ref_hab){
        $requete = "UPDATE contrat SET status_c = 'Annule' where ref_hab = :ref_hab";
        $data = array(":ref_hab"=>$ref_hab);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data); 

        $requete = "DELETE FROM appartement where ref_hab = :ref_hab;";
        $exe = $this->unPdo->prepare($requete);
        $data = array(":ref_hab"=>$ref_hab);
        $exe->execute($data); 
    }
    public function updateAppartementAnnonce($tab){
        $requete = "UPDATE appartement SET tarif_hab_bas = :tarif_hab_bas, tarif_hab_moy = :tarif_hab_moy, tarif_hab_hau = :tarif_hab_hau, description_hab = :description_hab, titre_hab = :titre_hab, capacite_hab = :capacite_hab, etage_ap = :etage_ap, type_ap = :type_ap WHERE ref_hab = :ref_hab;";
        $data = array(":tarif_hab_bas"=>$tab['tarif_hab_bas'],
                      ":tarif_hab_moy"=>$tab['tarif_hab_moy'],
                      ":tarif_hab_hau"=>$tab['tarif_hab_hau'],
                      ":description_hab"=>$tab['description_hab'],
                      ":titre_hab"=>$tab['titre_hab'],
                      ":capacite_hab"=>$tab['capacite_hab'],
                      ":etage_ap"=>$tab['etage_ap'],
                      ":type_ap"=>$tab['type_ap'],
                      ":ref_hab"=>$tab['ref_hab']
                      );
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function selectLikeAppartement($filtre){
        $requete = "select * from appartement where type_hab like :filtre or adr_hab like :filtre or cp_hab like :filtre or ville_hab like :filtre or tarif_hab_bas like :filtre or tarif_hab_moy like :filtre or tarif_hab_hau like :filtre or surface like :filtre or ;";
        $data = array(":filtre"=>"%".$filtre."%");
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }




    /******************************************************     RESERVATIONS     ******************************************************/
    public function selectAllReservation(){
        $requete = "SELECT * FROM reservation;";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }
    public function selectWhereReservation($ref_res){
        $requete = "SELECT * FROM reservation where ref_res = :ref_res;";
        $data = array(":ref_res"=>$ref_res);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function selectReservationWhereClient($id_c){
        $requete = "SELECT * FROM reservation WHERE id_c = :id_c";
        $data = array(":id_c"=>$id_c);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll(); 
    }
    public function insertReservation($tab){
        $requete = "INSERT INTO reservation(ref_res, date_res, nb_perso, date_debut, date_fin, etat_res, id_c, ref_hab) 
                    VALUES (null,curdate(),:nb_perso,:date_debut,:date_fin,'En attente',:id_c,:ref_hab);";
        $data = array(
                        ":nb_perso"=>$tab['nb_perso'],
                        ":date_debut"=>$tab['date_debut'],
                        ":date_fin"=>$tab['date_fin'],
                        ":id_c"=>$tab['id_c'],
                        ":ref_hab"=>$tab['ref_hab']
                    );
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function insertReservationAdmin($tab){
        $requete = "INSERT INTO reservation(ref_res, date_res, nb_perso, date_debut, date_fin, etat_res, id_c, ref_hab) 
                    VALUES (null,curdate(),:nb_perso,:date_debut,:date_fin,:etat_res,:id_c,:ref_hab);";
        $data = array(
                        ":nb_perso"=>$tab['nb_perso'],
                        ":date_debut"=>$tab['date_debut'],
                        ":date_fin"=>$tab['date_fin'],
                        ":etat_res"=>$tab['etat_res'],
                        ":id_c"=>$tab['id_c'],
                        ":ref_hab"=>$tab['ref_hab']
                    );
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function updateReservation($tab){
        $requete = "UPDATE reservation SET date_res = curdate(), nb_perso = :nb_perso, date_debut = :date_debut, date_fin = :date_fin, etat_res = :etat_res, id_c = :id_c, ref_hab = :ref_hab where ref_res = :ref_res;";
        $data = array(
                        ":nb_perso"=>$tab['nb_perso'],
                        ":date_debut"=>$tab['date_debut'],
                        ":date_fin"=>$tab['date_fin'],
                        ":etat_res"=>$tab['etat_res'], 
                        ":ref_res"=>$tab['ref_res'], 
                        ":id_c"=>$tab['id_c'], 
                        ":ref_hab"=>$tab['ref_hab'],
                        ":ref_res"=>$tab['ref_res']
                    );
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function deleteReservation($ref_res){
        $requete = "DELETE FROM reservation where ref_res = :ref_res;";
        $exe = $this->unPdo->prepare($requete);
        $data = array(":ref_res"=>$ref_res);
        $exe->execute($data);    
    } 
    public function annulerReservation($ref_res){
        $requete = "update reservation set etat_res = 'Annulee' where ref_res = :ref_res;";
        $data = array(":ref_res"=>$ref_res);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
    public function selectLikeReservation($filtre){
        $requete = "select * from reservation where date_res like :filtre or nb_perso like :filtre or etat_res like :filtre or date_debut like :filtre or date_fin like :filtre;";
        $data = array(":filtre"=>"%".$filtre."%");
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectCountReservationValidee(){
        $requete = "SELECT id_c, count(*) as nb_validee FROM reservation WHERE etat_res = 'validee' GROUP BY id_c;";
        $exe = $this->unPdo->prepare($requete);
        $exe->execute();
        return $exe->fetchAll();
    }




    /******************************************************     ADMINS     ******************************************************/
    public function selectWhereAdmin($email,$mdp){
        $requete = "SELECT * FROM admin where email_a = :email and mdp_a = :mdp;";
        $data = array(":email"=>$email,":mdp"=>$mdp);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }




    /******************************************************     PHOTOQ     ******************************************************/
    public function selectAllPhotoPrincipal(){
        $requete = "SELECT * FROM photos where is_principal = true;";
        $exe = $this->unPdo->prepare($requete);
        return $exe->fetchAll();
    }
    public function selectAllPhotosWhere($refHab){
        $requete = "SELECT url_photo FROM photos where ref_hab = :ref_hab
                    AND is_principal = false;";
         $data = array(":ref_hab"=>$refHab);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetchAll();
    }
    public function selectPhotoPrincipalHabitation($refHab){
        $requete = "SELECT url_photo FROM photos WHERE ref_hab = :ref_hab 
                    AND is_principal = TRUE;";
        $data = array(":ref_hab"=>$refHab);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
        return $exe->fetch();
    }
    public function insertPhoto($tab){
    $sql = "INSERT INTO photos (ref_hab, url_photo, is_principal)
            VALUES (:ref_hab, :url_photo, :is_principal)";

    $req = $this->unPdo->prepare($sql);
    $req->execute([
        ":ref_hab" => $tab["ref_hab"],
        ":url_photo" => $tab["url_photo"],
        ":is_principal" => $tab["is_principal"]
        ]);
    }
    public function deletePhotos($refHab){
        $sql = "DELETE FROM photos WHERE ref_hab = :ref_hab;";
        $req = $this->unPdo->prepare($sql);
        $req->execute([":ref_hab" => $refHab]);
    }




    /******************************************************     CONTRATS     ******************************************************/
    public function selectCountContratByProprio(){
        $sql = "SELECT id_p,count(*) AS nb_contrats FROM contrat GROUP BY id_p;";
        $req = $this->unPdo->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }




    /******************************************************     REINITIALISATION MDP     ******************************************************/
    public function verifCode($email,$code){
        $sql = "SELECT * FROM reset_mdp 
                    WHERE email = :email AND code = :code 
                    AND created_at > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
        $data = array(":email"=>$email, ":code"=>$code);
        $req = $this->unPdo->prepare($sql);
        $req->execute($data);
        return $req->fetch();
    }

    public function resetCode($email,$code){
        $sql = "REPLACE INTO reset_mdp(email, code, created_at) VALUES (:email,:code,now());";
        $data = array(":email"=>$email,":code"=>$code);
        $req = $this->unPdo->prepare($sql);
        $req->execute($data);
    }

    public function updateMdp($email,$newMdp){
        try{
            $this->unPdo->beginTransaction();

            $sql = "UPDATE utilisateur SET mdp = :newMdp WHERE email = :email;";
            $data = array(":newMdp"=>$newMdp, ":email"=>$email);
            $req = $this->unPdo->prepare($sql);
            $req->execute($data);

            $sql = "DELETE FROM reset_mdp WHERE email = :email;";
            $data = array(":email"=>$email);
            $req = $this->unPdo->prepare($sql);
            $req->execute($data);

            $this->unPdo->commit();

        }catch(Exception $e){
            $this->unPdo->rollBack(); 
            echo $e->getMessage();
            die;
        }
    }

    public function changerMdp($email,$nvMdp){
        $requete = "UPDATE utilisateur SET mdp = :nvMdp, date_mdp = curdate() WHERE email = :email";
        $data = array(":email"=>$email, ":nvMdp"=>$nvMdp);
        $exe = $this->unPdo->prepare($requete);
        $exe->execute($data);
    }
}

?>