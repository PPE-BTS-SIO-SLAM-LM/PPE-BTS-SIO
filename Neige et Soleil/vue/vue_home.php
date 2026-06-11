<section id="sectionSlider">
    <div class="slider">
        <img src="images/neige&soleil2.jpg" alt="" class="imgSlide active">
        <img src="images/neige&soleil1.png" alt="" class="imgSlide">
        <img src="images/neige&soleil3.jpg" alt="" class="imgSlide">
    </div>
</section>
<section id="sectionAnnonces">
    <div id="conteneurRechercheAnnonces">
        <form id="formRecherheAnnonces" action="index.php?page=1#formRecherheAnnonces" method="post">
            <div class="r">
                <label for="type">Type</label>
                <select name="type">
                    <option value="">Tout</option>
                    <option value="Appartement">Appartement</option>
                    <option value="Maison">Maison</option>
                </select>
            </div>
            <div class="r">
                <label for="prixMax">Prix max </label>
                <input type="number" name="prixMax" id="prixMax">
            </div>
            <div class="r">
                <label for="prixMin">Prix min </label>
                <input type="number" name="prixMin" id="prixMin">
            </div>
            <script>
                let prixMax = document.getElementById('prixMax');
                let prixMin = document.getElementById('prixMin');

                prixMax.addEventListener('input',()=>{
                    prixMin.max = prixMax.value;
                })
                prixMin.addEventListener('input',()=>{
                    prixMax.min = prixMin.value;
                })
            </script>
            <button type="submit" class="btnRechercheAnnonces" name="rechercher" translate="no">
                <span class="material-symbols-outlined icon-search" translate="no">search</span>
            </button>
        </form>
    </div>
    <div class="conteneurCardAnnonceHabitation">
        <?php if(isset($lesHabitations)): ?>
            <?php foreach ($lesHabitations as $uneHabitation):?>
                <?php 
                    $refHab = $uneHabitation['ref_hab'];
                    $photoPcpl = $unControleur->selectPhotoPrincipalHabitation($refHab);
                ?>
                <a href="index.php?page=10&ref_hab=<?= $uneHabitation['ref_hab']?>"  target="_blank">
                    <div class="cardAnnonceHabitation">
                        <?php if($photoPcpl != null): ?>
                        <img class="imgHabitation" src="images/habitations/<?= $photoPcpl['url_photo'] ?>" alt="">
                        <?php else : ?>
                            <img class="imgHabitation" src="" alt="">
                        <?php endif; ?>
                        <p class="cardTypeHab"><?= $uneHabitation['type_hab'];?></p>
                        <p class="cardVilleHab"><?= $uneHabitation['ville_hab'] ?></p>
                        <p class="cardTarifHab"><?= $uneHabitation['tarif_hab_moy'] ?>€ - nuit</p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(empty($lesHabitations)):?>
            <h3>Aucune habitation disponible</h3>
        <?php endif; ?>
    </div>
</section>
