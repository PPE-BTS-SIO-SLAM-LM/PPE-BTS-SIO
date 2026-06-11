<section>
    <h1 class="titreGest">Gestion des maisons</h1>

    <div class="superConteneurGestion">
        <!-- ================= FORMULAIRE (GAUCHE) ================= -->
        <div class="conteneurInsert">
            <h4>Ajouter/Modifier maison</h4>

                <form method="post" enctype="multipart/form-data" class="conteneurFormInsert">
                    <table class="tabFormInsert">

                        <tr>
                            <td>Adresse</td>
                            <td><input class="form-control" type="text" name="adr_hab"
                                value="<?= ($maison==null)?"":$maison['adr_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Code postal</td>
                            <td><input class="form-control" type="number" name="cp_hab"
                                value="<?= ($maison==null)?"":$maison['cp_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Ville</td>
                            <td><input class="form-control" type="text" name="ville_hab"
                                value="<?= ($maison==null)?"":$maison['ville_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Tarif bas (en euros)</td>
                            <td><input class="form-control" type="number" name="tarif_hab_bas"
                                value="<?= ($maison==null)?"":$maison['tarif_hab_bas']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Tarif moyen (en euros)</td>
                            <td><input class="form-control" type="number" name="tarif_hab_moy"
                                value="<?= ($maison==null)?"":$maison['tarif_hab_moy']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Tarif haut (en euros)</td>
                            <td><input class="form-control" type="number" name="tarif_hab_hau"
                                value="<?= ($maison==null)?"":$maison['tarif_hab_hau']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Surface</td>
                            <td><input class="form-control" type="number" name="surface"
                                value="<?= ($maison==null)?"":$maison['surface']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Proprietaire</td>
                            <td>
                                <select class="form-select" name="id_p" id="id_p" required>
                                    <?php
                                    if  ($maison!=null){
                                     foreach ($lesProprietaires as $unProrprietaire)
                                        if ($unProrprietaire['id_p'] == $maison['id_p']){
                                            echo '<option value="'.$unProrprietaire['id_p'].'">'.$unProrprietaire['nom'].' - '.$unProrprietaire['prenom'].' </option>';
                                            break;
                                        }
                                    }else {
                                    echo '<option value=""> Sélectionner un propriétaire  </option>';
                                    }

                                     foreach ($lesProprietaires as $unProrprietaire){
                                        if ($unProrprietaire['id_p'] != $maison['id_p']){
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
                                <textarea class="form-control" name="description_hab" rows="3" required><?= ($maison==null)?"":$maison['description_hab']; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Titre</td>
                            <td><input class="form-control" type="text" name="titre_hab"
                                value="<?= ($maison==null)?"":$maison['titre_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Capacité</td>
                            <td><input class="form-control" type="number" name="capacite_hab"
                                value="<?= ($maison==null)?"":$maison['capacite_hab']; ?>" required></td>
                        </tr>

                        <tr>
                            <td>Caractéristique</td>
                            <td><input class="form-control" type="text" name="carac_m"
                                value="<?= ($maison==null)?"":$maison['carac_m']; ?>" required></td>
                        </tr>

                    </table>

                    <!-- Erreurs -->
                    <?php if(!empty($_SESSION['erreurs'])): ?>
                        <?php foreach($_SESSION['erreurs'] as $uneErreur): ?>
                            <div class="alert alert-danger p-2"><?= $uneErreur ?></div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['erreurs']); ?>
                    <?php endif; ?>

                    <div class="conteneurBtFormInsert">
                        <a href="index.php?page=28" class="btnAnnuler btAnnulerFormInsert">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                        <button class="btnValider btValiderFormInsert"
                            type="submit"
                            <?= ($maison==null)
                                ? 'name="valider"'
                                : 'name="modifier"' ?>>
                            <span class="material-symbols-outlined">check</span>
                        </button>
                    </div>
                <?= ($maison==null)?"":'<input type="hidden" name="ref_hab" value="'.$maison['ref_hab'].'">';?>
            </form>
        </div>

        <!-- ================= TABLE (DROITE) ================= -->
        <div class="conteneurListe">
            <h4>Liste maisons</h4>
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
                        <?php if (isset($lesMaisons)): ?>
                            <?php foreach($lesMaisons as $uneMaison): ?>
                                <tr>
                                    <td><?= $uneMaison['ref_hab'] ?></td>
                                    <td><?= $uneMaison['type_hab'] ?></td>
                                    <td><?= $uneMaison['adr_hab'] ?></td>
                                    <td><?= $uneMaison['cp_hab'] ?></td>
                                    <td><?= $uneMaison['ville_hab'] ?></td>
                                    <td><?= $uneMaison['tarif_hab_bas']?>€</td>
                                    <td><?= $uneMaison['tarif_hab_moy'] ?>€</td>
                                    <td><?= $uneMaison['tarif_hab_hau'] ?>€</td>
                                    <td><?= $uneMaison['surface'] ?> m<sup>2</sup></td>
                                    <td><?= $uneMaison['id_p'] ?></td>
                                    <td><?= $uneMaison['titre_hab'] ?></td>
                                    <td><?= $uneMaison['capacite_hab'] ?> personne(s)</td>

                                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                        <td>
                                            <a class="btn btn-sm btn-danger me-1"
                                               href="index.php?page=28&action=sup&ref_hab=<?= $uneMaison['ref_hab'] ?>"
                                               onclick="return confirm('Supprimer cette habitation ?')">
                                                <span class="material-symbols-outlined btDelete">delete</span>
                                            </a>

                                            <a class="btn btn-sm btn-warning"
                                               href="index.php?page=28&action=edit&ref_hab=<?= $uneMaison['ref_hab'] ?>">
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
                <?= (isset($lesMaisons)) ? "Nombre de maison : " . count($lesMaisons) : "" ?>
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

