<section>
    <h1 class="titreGest">Gestion des appartements</h1>

    <div class="superConteneurGestion">

        <!-- ================= FORMULAIRE (GAUCHE) ================= -->
        <div class="conteneurInsert">
            <h4>Ajouter/Modifier appartement</h4>
                
                <form method="post" enctype="multipart/form-data" class="conteneurFormInsert">
                    <table class="tabFormInsert">

                        <tr>
                            <td>Adresse</td>
                            <td><input class="form-control" type="text" name="adr_hab"
                                value="<?= ($appartement==null)?"":$appartement['adr_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Code postal</td>
                            <td><input class="form-control" type="number" name="cp_hab"
                                value="<?= ($appartement==null)?"":$appartement['cp_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Ville</td>
                            <td><input class="form-control" type="text" name="ville_hab"
                                value="<?= ($appartement==null)?"":$appartement['ville_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Tarif bas (en euros)</td>
                            <td><input class="form-control" type="number" name="tarif_hab_bas"
                                value="<?= ($appartement==null)?"":$appartement['tarif_hab_bas']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Tarif moyen (en euros)</td>
                            <td><input class="form-control" type="number" name="tarif_hab_moy"
                                value="<?= ($appartement==null)?"":$appartement['tarif_hab_moy']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Tarif haut (en euros)</td>
                            <td><input class="form-control" type="number" name="tarif_hab_hau"
                                value="<?= ($appartement==null)?"":$appartement['tarif_hab_hau']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Surface</td>
                            <td><input class="form-control" type="number" name="surface"
                                value="<?= ($appartement==null)?"":$appartement['surface']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Proprietaire</td>
                            <td>
                                <select class="form-select" name="id_p" id="id_p" required>
                                    <?php
                                    if  ($appartement!=null){
                                     foreach ($lesProprietaires as $unProrprietaire)
                                        if ($unProrprietaire['id_p'] == $appartement['id_p']){
                                            echo '<option value="'.$unProrprietaire['id_p'].'">'.$unProrprietaire['nom'].' - '.$unProrprietaire['prenom'].' </option>';
                                            break;
                                        }
                                    }else {
                                    echo '<option value=""> Sélectionner un propriétaire  </option>';
                                    }

                                     foreach ($lesProprietaires as $unProrprietaire){
                                        if ($unProrprietaire['id_p'] != $appartement['id_p']){
                                        ?>
                                        <option value="<?= $unProrprietaire['id_p']?>">
                                            <?= $unProrprietaire['id_p']." - ".$unProrprietaire['nom']." - ".$unProrprietaire['prenom'];?>
                                        </option>
                                    <?php } } ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Photos</td>
                            <td><input class="form-control" type="file" name="photos[]" id="photos" multiple></td>
                        </tr>

                        <tr>
                            <td>Description</td>
                            <td>
                                <textarea class="form-control" name="description_hab" rows="3" required><?= ($appartement==null)?"":$appartement['description_hab']; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Titre</td>
                            <td><input class="form-control" type="text" name="titre_hab"
                                value="<?= ($appartement==null)?"":$appartement['titre_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Capacité</td>
                            <td><input class="form-control" type="number" name="capacite_hab"
                                value="<?= ($appartement==null)?"":$appartement['capacite_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>N° Etage</td>
                            <td><input class="form-control" type="number" name="etage_ap"
                                value="<?= ($appartement==null)?"":$appartement['etage_ap']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Type d'appartement</td>
                            <td><input class="form-control" type="text" name="type_ap"
                                value="<?= ($appartement==null)?"":$appartement['type_ap']; ?>" required></td>
                        </tr>

                    </table>

                    <div class="conteneurMsgErreurReussite">
                        <!-- Erreurs -->
                        <?php if(!empty($_SESSION['msg-erreurs'])): ?>
                            <?php foreach($_SESSION['msg-erreurs'] as $uneErreur): ?>
                                <span style="color:red"><?= $uneErreur ?></span>
                            <?php endforeach; ?>
                            <?php unset($_SESSION['msg-erreurs']); ?>
                        <?php endif; ?>
                        <!-- Reussite -->
                        <?php if(!empty($_SESSION['msg-reussite'])): ?>
                            <span style="color:green"><?= $_SESSION['msg-reussite']; ?></span>
                            <?php unset($_SESSION['msg-reussite']); ?>
                        <?php endif; ?>
                    </div>

                    <div class="conteneurBtFormInsert">
                        <a href="index.php?page=29" class="btnAnnuler btAnnulerFormInsert">
                            <span class="material-symbols-outlined">close</span>
                        </a>

                        <button class="btnValider btValiderFormInsert"
                            type="submit"
                            <?= ($appartement==null)
                                ? 'name="valider"'
                                : 'name="modifier"' ?>>
                            <span class="material-symbols-outlined">check</span>
                        </button>
                    </div>
                    <?= ($appartement==null)?"":'<input type="hidden" name="ref_hab" value="'.$appartement['ref_hab'].'">';?>
                </form>
        </div>

        <!-- ================= TABLE (DROITE) ================= -->
        <div class="conteneurListe">
            <h4>Liste appartements</h4>
            <div class="conteneurFiltrer">
                <p class="filtrerPar">Filtrer par :</p>

                <!-- Filtre -->
                <form method="post" class="listes">
                    <input class="form-control" type="text" name="filtre">
                    <button class="btFiltrer" type="submit" name="filtrer">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </form>
            </div>

                <!-- Table -->
                <div class="conteneurTabListe">
                    <table class="tabListe">
                        <thead class="table-dark">
                            <tr>
                                <th>Réf</th>
                                <th>Type</th>
                                <th>Adresse</th>
                                <th>Cp</th>
                                <th>Ville</th>
                                <th>Tarif min</th>
                                <th>Tarif moy</th>
                                <th>Tarif max</th>
                                <th>Surface</th>
                                <th>Propriétaire</th>
                                <th>Titre</th>
                                <th>Capacité</th>

                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
                                    echo "<th>Actions</th>";
                                } ?>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (isset($lesAppartements)): ?>
                            <?php foreach($lesAppartements as $unAppartement): ?>
                                <tr>
                                    <td><?= $unAppartement['ref_hab'] ?></td>
                                    <td><?= $unAppartement['type_hab'] ?></td>
                                    <td><?= $unAppartement['adr_hab'] ?></td>
                                    <td><?= $unAppartement['cp_hab'] ?></td>
                                    <td><?= $unAppartement['ville_hab'] ?></td>
                                    <td><?= $unAppartement['tarif_hab_bas'] ?>€</td>
                                    <td><?= $unAppartement['tarif_hab_moy'] ?>€</td>
                                    <td><?= $unAppartement['tarif_hab_hau'] ?>€</td>
                                    <td><?= $unAppartement['surface'] ?> m<sup>2</sup></td>
                                    <td><?= $unAppartement['id_p'] ?></td>
                                    <td><?= $unAppartement['titre_hab'] ?></td>
                                    <td><?= $unAppartement['capacite_hab'] ?> personne(s)</td>

                                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                        <td>
                                            <a class="btn btn-sm btn-danger me-1"
                                               href="index.php?page=29&action=sup&ref_hab=<?= $unAppartement['ref_hab'] ?>"
                                               onclick="return confirm('Supprimer cette habitation ?')">
                                                <span class="material-symbols-outlined btDelete">delete</span>
                                            </a>

                                            <a class="btn btn-sm btn-warning"
                                               href="index.php?page=29&action=edit&ref_hab=<?= $unAppartement['ref_hab'] ?>">
                                                <span class="material-symbols-outlined btEdit">edit</span>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <p class="nbTotal">
                    <?= (isset($lesAppartements)) ? "Nombre d'appartement : " . count($lesAppartements) : "" ?>
                </p>
        </div>
    </div>

    <!-- Script limite photos -->
    <script>
        const photos = document.getElementById('photos');

        photos.addEventListener("change", () => {
            if (photos.files.length > 3) {
                photos.value = "";
                alert("Maximum 3 photos autorisées");
            }
        });
    </script>

</section>

