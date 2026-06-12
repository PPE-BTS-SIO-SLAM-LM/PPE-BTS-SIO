<section>
<h1 id="titreConfirmationResa">Confirmez votre réservation !</h1>
<div class="conteneurPrincipalConfirmationResa">
    <div class="cardTeteConfirmationResa">
        <?php $photoPcpl = $unControleur->selectPhotoPrincipalHabitation($data['refHab']); ?>
        <div class="conteneurImgConfirmationResa"><img class="imgConfirmationResa" src="images/habitations/<?= $photoPcpl['url_photo'] ?>" alt=""></div>
        <div class="conteneurTitreDataHabitation">
            <h3><?= htmlspecialchars($data['titreHabitation']) ?></h3>
            <p class="descConfirmResa"><?= htmlspecialchars($data['typeHabitation']) ?></p>
            <p class="descConfirmResa"><?= htmlspecialchars($data['adresseHabitation']) ?></p>
            <p class="descConfirmResa"><?= htmlspecialchars($data['codePostalHabitation']) ?></p>
            <p class="descConfirmResa"><?= htmlspecialchars($data['villeHabitation']) ?></p>
        </div>
    </div>
    <div class="dataAnnulationResa">
        <h4>Annulation gratuite</h4>
        <p class="descConfirmResa">Annulez maximum 24h avant afin de recevoir un remboursement intégral</p>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Nom</h4>
            <p class="descConfirmResa"><?= $_SESSION['nom'] ?></p>
        </div>
        <div>
            <a href="index.php?page=6" class="modifierInfos">modifier</a>
        </div>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Prénom</h4>
            <p class="descConfirmResa"><?= $_SESSION['prenom'] ?></p>
        </div>
        <div>
            <a href="index.php?page=6" class="modifierInfos">modifier</a>
        </div>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Email</h4>
            <p class="descConfirmResa"><?= $_SESSION['email'] ?></p>
        </div>
        <div>
            <a href="index.php?page=6" class="modifierInfos">modifier</a>
        </div>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Tel</h4>
            <p class="descConfirmResa"><?= $_SESSION['tel'] ?></p>
        </div>
        <div>
            <a href="index.php?page=6" class="modifierInfos">modifier</a>
        </div>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Dates</h4>
            <p class="descConfirmResa"> Début : <?= htmlspecialchars($data['arrivee'])?> / Fin : <?= htmlspecialchars($data['depart'])?></p>
        </div>
        <div>
            <a href="index.php?page=10&ref_hab=<?= htmlspecialchars($data['refHab']) ?>" class="modifierInfos">modifier</a>
        </div>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Voyageurs</h4>
            <p class="descConfirmResa"><?= htmlspecialchars($data['voyageurs']) ?></p>
        </div>
        <div>
            <a href="index.php?page=10&ref_hab=<?= htmlspecialchars($data['refHab']) ?>" class="modifierInfos">modifier</a>
        </div>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Détail du prix</h4>
            <p class="descConfirmResa"><?= htmlspecialchars($data['nbJours']) ?> nuits x <?= htmlspecialchars($data['prixParNuit']) ?>€</p>
        </div>
    </div>
    <div class="dataConfirmationResa">
        <div>
            <h4>Total</h4>
            <p class="descConfirmResa"><?= htmlspecialchars($data['prixTotalHidden']) ?>€</p>
        </div>
    </div>
    <form action="" method="post" id="formBtConfirmationResa">
        <a href="index.php?page=10&ref_hab=<?= htmlspecialchars($data['refHab']) ?>" class="btAnnulerFormInsert">
            <span class="material-symbols-outlined">close</span>
        </a>
        <button type="submit" name="confirmer" class="btValiderFormInsert">
            <span class="material-symbols-outlined">check</span>
        </button>

        <input type="hidden" name="nb_perso" value="<?= htmlspecialchars($data['voyageurs']) ?>">
        <input type="hidden" name="date_debut" value="<?= htmlspecialchars($data['arrivee']) ?>">
        <input type="hidden" name="date_fin" value="<?= htmlspecialchars($data['depart']) ?>">
        <input type="hidden" name="id_c" value="<?= $_SESSION['id'] ?>">
        <input type="hidden" name="ref_hab" value="<?= htmlspecialchars($data['refHab']) ?>">

    </form>
</div>
</section>


