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
            <td class="infoPersoCompte"><?= ($leClient == null)?"":$leClient['adresse'];?></td>
        </tr>
        <tr>
            <th>CP</th>
            <td class="infoPersoCompte"><?= ($leClient == null)?"":$leClient['cp'];?></td>
        </tr>
        <tr>
            <th>Ville</th>
            <td class="infoPersoCompte"><?= ($leClient == null)?"":$leClient['ville'];?></td>
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
    <a href="index.php?page=20" class="btModifier">
        <span class="material-symbols-outlined" translate="no">edit</span>
    </a>
</div>



<div class="infos_activites">
    <?php if(isset($_SESSION['msg-annul-reservation'])):?>
        <h2 style="color:green"><?= $_SESSION['msg-annul-reservation'] ?></h2>
        <?php unset($_SESSION['msg-annul-reservation']);?>
    <?php endif; ?>

    <h4>Mes réservations</h4>

    <div class="conteneurCardsResa">

    <?php if(!empty($resaClient)): ?>
        <?php foreach($resaClient as $resa): ?>


            <div class="cardResa">
                <table class="tabCardResa">
                    <tr>
                        <td>Réf</td>
                        <td><?= htmlspecialchars($resa['ref_res']);?></td>
                    </tr>
                    <tr>
                        <td>Habitation</td>
                        <td><?= htmlspecialchars($resa['ref_hab']);?></td>
                    </tr>
                    <tr>
                        <td>Personnes</td>
                        <td><?= htmlspecialchars($resa['nb_perso']);?></td>
                    </tr>
                    <tr>
                        <td>Début</td>
                        <td><?= htmlspecialchars($resa['date_debut']);?></td>
                    </tr>
                    <tr>
                        <td>Fin</td>
                        <td><?= htmlspecialchars($resa['date_fin']);?></td>
                    </tr>
                    <tr>
                        <td>Etat</td>
                        <td><?= htmlspecialchars($resa['etat_res']);?></td>
                    </tr>
                </table>

                <div>
                    <?php if ($resa['etat_res'] == 'en demande' || $resa['date_debut'] >= date('Y-m-d')):?>
                        <a href="index.php?page=6&action=sup&ref_res=<?= $resa['ref_res'] ?>" id="btAnnulerReservation"
                            onclick="return confirm('Voulez vous annuler cette réservation ?')">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    <?php else: ?>
                        <span class="material-symbols-outlined" id="btReservationValidee">check</span>
                    <?php endif; ?>

                    <a href="generateurContratClient.php?ref_res=<?= $resa['ref_res'] ?>" class="btVoirContrat" target="_blank">
                        <span class="material-symbols-outlined" translate="no">visibility</span>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucune réservation à ce jour</p>
    <?php endif; ?>

</div>

</section>