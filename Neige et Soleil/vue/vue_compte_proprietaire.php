<section>

    <h1>Mon compte</h1>
<div class="vue_compte">
<div class="infos_perso">
    <?php if(isset($_SESSION['msg-update'])):?>
        <h2 style="color:green"><?= $_SESSION['msg-update'] ?></h2>
    <?php unset($_SESSION['msg-update']);?>
    <?php endif; ?>
    

    <h4>Mes informations</h4>
    <table>
        <tr>
            <th id="top">Nom</th>
            <td id="top" class="infoPersoCompte"><?= ($utilisateur == null)?"":$utilisateur['nom'];?></td>
        </tr>
        <tr>
            <th>Prénom</th>
            <td class="infoPersoCompte"><?= ($utilisateur == null)?"":$utilisateur['prenom'];?></td>
        </tr>
        <tr>
            <th>Adresse</th>
            <td class="infoPersoCompte"><?= ($leProprietaire == null)?"":$leProprietaire['adresse'];?></td>
        </tr>
        <tr>
            <th>CP</th>
            <td class="infoPersoCompte"><?= ($leProprietaire == null)?"":$leProprietaire['cp'];?></td>
        </tr>
        <tr>
            <th>Ville</th>
            <td class="infoPersoCompte"><?= ($leProprietaire == null)?"":$leProprietaire['ville'];?></td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td class="infoPersoCompte"><?= ($utilisateur == null)?"":$utilisateur['email'];?></td>
        </tr>
        <tr>
            <th id="bottom">Tél</th>
            <td id="bottom" class="infoPersoCompte"><?= ($utilisateur == null)?"":$utilisateur['tel'];?></td>
        </tr>
    </table>
    <a href="index.php?page=21" class="btModifier">
        <span class="material-symbols-outlined" translate="no">edit</span>
    </a>
</div>



<div class="infos_activites">
    <?php if(isset($_SESSION['msg-update-habitation'])):?>
        <h2 style="color:green"><?= $_SESSION['msg-update-habitation'] ?></h2>
    <?php unset($_SESSION['msg-update-habitation']);?>
    <?php endif; ?>
    <?php if(isset($_SESSION['msg-supp-habitation'])):?>
        <h2 style="color:green"><?= $_SESSION['msg-supp-habitation'] ?></h2>
    <?php unset($_SESSION['msg-supp-habitation']);?>
    <?php endif; ?>
    
    
    <h4>Mes habitations</h4>

    <div class="conteneurCardsHab">

    <?php if(!empty($habProprio)): ?>
    <?php foreach($habProprio as $hab): ?>

    <div class="cardHab">
        <table class="tabCardHab">
            <tr>
                <td>ID :</td>
                <td><?= htmlspecialchars($hab['ref_hab']);?></td>
            </tr>
            <tr>
                <td>Type :</td>
                <td><?= htmlspecialchars($hab['type_hab']);?></td>
            </tr>
            <tr>
                <td>Adresse :</td>
                <td><?= htmlspecialchars($hab['adr_hab']);?> </td>
            </tr>
            <tr>
                <td>Code postal :</td>
                <td><?= htmlspecialchars($hab['cp_hab']);?> </td>
            </tr>
            <tr>
                <td>Ville :</td>
                <td><?= htmlspecialchars($hab['ville_hab']);?> </td>
            </tr>
            <tr>
                <td>Surface :</td>
                <td><?= htmlspecialchars($hab['surface']."m2");?></td>
            </tr>
        </table>
        <div>
            <a href="index.php?page=7&action=sup&ref_hab=<?= $hab['ref_hab'] ?>" id="btSupprimerHabitation"
                onclick="return confirm('Voulez vous supprimer cette habitation ?')">
                <span class="material-symbols-outlined" translate="no">close</span>
            </a>
                <?php 
                if ($hab['type_hab'] == 'Maison') {
                    echo '<a href="index.php?page=26&action=modif&ref_hab=' . $hab['ref_hab'] . '" class="btModifier">
                            <span class="material-symbols-outlined" translate="no">edit</span>
                        </a>';
                } elseif ($hab['type_hab'] == 'Appartement') {
                    echo '<a href="index.php?page=27&action=modif&ref_hab=' . $hab['ref_hab'] . '" class="btModifier">
                            <span class="material-symbols-outlined" translate="no">edit</span>
                        </a>';
                } 
                ?>
            <a href="generateurContratProprietaire.php?ref_hab=<?= $hab['ref_hab'] ?>" class="btVoirContrat" target="_blank">
                <span class="material-symbols-outlined" translate="no">visibility</span>
            </a>
        </div>
    </div>  
    
    <?php endforeach; ?>
    <?php else :?>
        <p>Aucune habitation enregistrée</p>
    <?php endif; ?>
    </div>
    <a href="index.php?page=23" id="btAjouterHabitation" translate="no">
        Ajouter une habitation
        <span class="material-symbols-outlined">add</span>
    </a>
    </div>
</section>