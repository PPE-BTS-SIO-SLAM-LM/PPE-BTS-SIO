<?php 
    if(isset($_GET['ref_hab'])){
        $refHab = $_GET['ref_hab'];

        $habitation = $unControleur->selectWhereHabitation($refHab);
        $photoPrincipal = $unControleur->selectPhotoPrincipalHabitation($refHab);
        $photosSecondaires = $unControleur->selectAllPhotosWhere($refHab);
    }
?>

 <script>
    function calculPrix() { 
        const prixParNuit = <?=$habitation['tarif_hab_moy']?>; 
        const debut = new Date(document.getElementById('arrivee').value); 
        const fin = new Date(document.getElementById('depart').value); 

        let prix = prixParNuit;
        let nbJours = 1;
                        
        if (!isNaN(debut.getTime()) && !isNaN(fin.getTime()) && fin > debut) { 
            const diffTime = fin - debut; 
            nbJours = diffTime / (1000 * 60 * 60 * 24);
            prix = nbJours * prixParNuit; 
            
            document.getElementById('prixTotal').innerHTML = `<span class="titreNbJours">Total : </span> 
                                                              <span class="titrePrix">${prix} €</span>`;

        } else {
            document.getElementById('prixTotal').innerHTML = `<span>1 nuit - </span>  
                                                              <span>${prixParNuit} €</span>`;

        } 

        document.getElementById('prixTotalHidden').value = prix;
        document.getElementById('nbJours').value = nbJours;
        document.getElementById('prixParNuit').value = prixParNuit;
    } 

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
            calculPrix();
        });

        depart.addEventListener('change', calculPrix);

        calculPrix();
    });
</script>

<?php 
    if(isset($_POST['reserver'])){
        $arrivee = $_POST['arrivee'];
        $depart = $_POST['depart'];
        $voyageurs = $_POST['voyageurs'];

        if(isset($_SESSION['email']) && $_SESSION['role'] == 'client'){
            if($depart > $arrivee){
                if($voyageurs > 0 && $voyageurs <= $habitation['capacite_hab']){
                    //gérer la resa ici
                    $_SESSION['reservation'] = $_POST;
                    header("Location: index.php?page=11");
                    exit; 
                }else{
                    echo "<p style='color:red'>";
                    echo "Veuillez choisir un nombre de voyageurs respectant les limites";
                    echo "</p>";
                }
        
            }else{
                echo "<p style='color:red'>";
                echo "Veuillez choisir une date depart supérieur a la date d'arrivée";
                echo "</p>";
            }
            
        }else{
            $_SESSION['msg-login-resa'] = "Veuillez vous connecter ou créer un compte pour pouvoir réserver une habitation !";
            header("Location: index.php?page=8");
        }
    }
    
    require_once("vue/vue_reservation_habitation.php");
?>


     


