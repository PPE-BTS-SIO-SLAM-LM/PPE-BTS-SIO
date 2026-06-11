<section>
    <h1 class="titreGest">Gestion des réservations</h1>

    <div class="superConteneurGestion">
        <!-- ================= FORMULAIRE (GAUCHE) ================= -->
        <div class="conteneurInsert">
            <h4>Ajouter/Modifier réservation</h4>

                <form method="post" class="conteneurFormInsert">
                    <table class="tabFormInsert">
                        <tr>
                            <td>Nombre personnes</td>
                            <td>
                                <input class="form-control" type="number" name="nb_perso" id="nb_perso"
                                    min="1"
                                    max="<?= (!$habitation)?"":$habitation['capacite_hab']?>"
                                    value="<?= ($reservation==null)?"1":$reservation['nb_perso']?>"
                                    required>
                            </td>
                        </tr>

                        <tr>
                            <td>Début séjour</td>
                            <td>
                                <input class="form-control" type="date" name="date_debut" id="arrivee"
                                    value="<?= ($reservation==null)?"":$reservation['date_debut'] ?>" required>
                            </td>
                        </tr>

                        <tr>
                            <td>Fin séjour</td>
                            <td>
                                <input class="form-control" type="date" name="date_fin" id="depart"
                                    value="<?= ($reservation==null)?"":$reservation['date_fin'] ?>" required>
                            </td>
                        </tr>

                        <tr>
                            <td>Etat</td>
                            <td>
                                <select class="form-select" name="etat_res" required>
                                    <option value="<?= ($reservation==null)?"":$reservation['etat_res'];?>">
                                        <?= ($reservation==null)?"Choisir état":$reservation['etat_res'];?>
                                    </option>
                                    <option value="Validee">Validée</option>
                                    <option value="En attente">En attente</option>
                                    <option value="Annulee">Annulée</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Client</td>
                            <td>
                                <select class="form-select" name="id_c" id="id_c" required>
                                    <?php
                                    if  ($reservation!=null){
                                     foreach ($lesClients as $unClient)
                                        if ($unClient['id_c'] == $reservation['id_c']){
                                            echo '<option value="'.$unClient['id_c'].'">'.$unClient['nom'].' - '.$unClient['prenom'].' </option>';
                                            break;
                                        }
                                    }else {
                                    echo '<option value=""> Sélectionner un client  </option>';
                                    }

                                     foreach ($lesClients as $unClient){
                                        if ($unClient['id_c'] != $reservation['id_c']){
                                        ?>
                                        <option value="<?= $unClient['id_c']?>">
                                            <?= $unClient['id_c']." - ".$unClient['nom']." - ".$unClient['prenom'];?>
                                        </option>
                                    <?php } } ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Habitation</td>
                            <td>
                                <select class="form-select" name="ref_hab" id="ref_hab" required>
                                    <?php
                                    if  ($reservation!=null){
                                     foreach ($lesHabitations as $uneHabitation)
                                        if ($uneHabitation['ref_hab'] == $reservation['ref_hab']){
                                            echo '<option value="'.$uneHabitation['ref_hab'].'">'.$uneHabitation['ref_hab'].' - '.$uneHabitation['type_hab'].' - '.$uneHabitation['ville_hab'].' </option>';
                                            break;
                                        }
                                    }else {
                                    echo '<option value=""> Sélectionner habitation  </option>';
                                    }

                                     foreach ($lesHabitations as $uneHabitation){
                                        if ($uneHabitation['ref_hab'] != $reservation['ref_hab']){
                                        ?>
                                        <option value="<?= $uneHabitation['ref_hab']?>"
                                                capa-max="<?= $uneHabitation['capacite_hab']?>">
                                            <?= $uneHabitation['ref_hab']." - ".$uneHabitation['type_hab']." - ".$uneHabitation['ville_hab'];?>
                                        </option>
                                    <?php } } ?>
                                </select>
                            </td>
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
                        <button class="btnAnnuler btAnnulerFormInsert" type="submit" name="annuler">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                        <button class="btnValider btValiderFormInsert"
                            type="submit"
                            <?= ($reservation==null)
                                ? 'name="valider"'
                                : 'name="modifier"' ?>>
                            <span class="material-symbols-outlined">check</span>
                        </button>
                    </div>
                    <?= ($reservation==null)?"":'<input type="hidden" name="ref_res" value="'.$reservation['ref_res'].'">';?>
                </form>
    
        </div>

        <!-- ================= TABLE (DROITE) ================= -->
        <div class="conteneurListe">
            <h4>Liste réservations</h4>
            <div class="conteneurFiltrer">
                <p class="filtrerPar">Filtrer par </p>

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
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date réservation</th>
                            <th>Nb pers</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Etat</th>
                            <th>Client</th>
                            <th>Habitation</th>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
                                echo "<th>Actions</th>";
                            } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($lesReservations)): ?>
                            <?php foreach ($lesReservations as $uneReservation): ?>
                                <tr>
                                    <td><?= $uneReservation['ref_res'] ?></td>
                                    <td><?= $uneReservation['date_res'] ?></td>
                                    <td><?= $uneReservation['nb_perso'] ?></td>
                                    <td><?= $uneReservation['date_debut'] ?></td>
                                    <td><?= $uneReservation['date_fin'] ?></td>
                                    <td><?= $uneReservation['etat_res'] ?></td>
                                    <td><?= $uneReservation['id_c'] ?></td>
                                    <td><?= $uneReservation['ref_hab'] ?></td>

                                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                    <td>
                                        <a class="btn btn-sm btn-danger me-1" 
                                            href="index.php?page=5&action=sup&ref_res=<?= $uneReservation['ref_res'] ?>"
                                            onclick="return confirm('Supprimer cette réservation ?')">
                                            <span class="material-symbols-outlined btDelete">delete</span>
                                        </a>
                                        <a class="btn btn-sm btn-warning" 
                                            href="index.php?page=5&action=edit&ref_res=<?= $uneReservation['ref_res'] ?>">
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
                <?= (isset($lesReservations)) ? "Nombre de réservations : " . count($lesReservations) : "" ?>
            </p>
        </div>
    </div>

</section>
 