 <section>
    <h1 class="titreGest">Gestion des propriétaires</h1>
    
    <div class="superConteneurGestion">
        <!-- ================= FORMULAIRE (GAUCHE) ================= -->
        <div class="conteneurInsert">
            <h4>Ajouter / Modifier propriétaire</h4>

                <form method="post" class="conteneurFormInsert">
                    <table class="tabFormInsert">
                        <tr>
                            <td>Nom</td>
                            <td><input class="form-control" type="text" name="nom"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['nom'];?>" required></td>
                        </tr>

                        <tr>
                            <td>Prénom</td>
                            <td><input class="form-control" type="text" name="prenom"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['prenom'];?>" required></td>
                        </tr>

                        <tr>
                            <td>E-mail</td>
                            <td><input class="form-control" type="email" name="email"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['email'];?>" required></td>
                        </tr>

                        <tr>
                            <td>Mot de passe</td>
                            <td><input class="form-control" type="text" name="mdp"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['mdp'];?>" required></td>
                        </tr>

                        <tr>
                            <td>Adresse</td>
                            <td><input class="form-control" type="text" name="adresse"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['adresse'];?>" required></td>
                        </tr>

                        <tr>
                            <td>Code postal</td>
                            <td><input class="form-control" type="text" name="cp"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['cp'];?>" required></td>
                        </tr>

                        <tr>
                            <td>Ville</td>
                            <td><input class="form-control" type="text" name="ville"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['ville'];?>" required></td>
                        </tr>

                        <tr>
                            <td>Tél</td>
                            <td><input class="form-control" type="text" name="tel"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['tel'];?>" required></td>
                        </tr>

                        <tr>
                            <td>RIB</td>
                            <td><input class="form-control" type="text" name="rib"
                                value="<?= ($leProprietaire == null)?"":$leProprietaire['RIB'];?>" required></td>
                        </tr>

                    </table>

                    <!-- Erreurs -->
                    <?php if(!empty($_SESSION['msg-erreurs'])): ?>
                        <?php foreach($_SESSION['msg-erreurs'] as $uneErreur): ?>
                            <div class="alert alert-danger p-2"><?= $uneErreur ?></div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['msg-erreurs']); ?>
                    <?php endif; ?>

                    <div class="conteneurBtFormInsert">
                        <button class="btnAnnuler btAnnulerFormInsert" type="submit" name="annuler">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                        <button class="btnValider btValiderFormInsert"
                            type="submit"
                            <?= ($leProprietaire==null)
                                ? 'name="valider"'
                                : 'name="modifier"' ?>>
                            <span class="material-symbols-outlined">check</span>
                        </button>
                    </div>
                    <?= ($leProprietaire==null)? '' : '<input type="hidden" name="id_user" value="'.$leProprietaire['id_p'].'">' ?>
                </form>
        </div>

        <!-- ================= TABLE (DROITE) ================= -->
        <div class="conteneurListe">
            <h4>Liste propriétaires</h4>
            <div class="conteneurFiltrer">
                <p class="filtrerPar">Filtrer par </p>
                <!-- Filtre -->
                <form method="post" action="index.php?page=3#tabListeProprio" class="listes">
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
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Mdp</th>
                            <th>Adresse</th>
                            <th>CP</th>
                            <th>Ville</th>
                            <th>Tel</th>
                            <th>RIB</th>

                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
                                echo "<th>Actions</th>";
                            } ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($lesProprietaires)): ?>
                        <?php foreach ($lesProprietaires as $unProprietaire): ?>
                            <tr>
                                <td><?= $unProprietaire['id_p'] ?></td>
                                <td><?= $unProprietaire['nom'] ?></td>
                                <td><?= $unProprietaire['prenom'] ?></td>
                                <td><?= $unProprietaire['email'] ?></td>
                                <td><?= $unProprietaire['mdp'] ?></td>
                                <td><?= $unProprietaire['adresse'] ?></td>
                                <td><?= $unProprietaire['cp'] ?></td>
                                <td><?= $unProprietaire['ville'] ?></td>
                                <td><?= $unProprietaire['tel'] ?></td>
                                <td><?= $unProprietaire['RIB'] ?></td>

                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                <td>
                                    <a class="btn btn-sm btn-danger me-1"
                                        href="index.php?page=3&action=sup&id_p=<?= $unProprietaire['id_p'] ?>"
                                        onclick="return confirm('Supprimer ce propriétaire ?')">
                                        <span class="material-symbols-outlined btDelete">delete</span>
                                    </a>

                                    <a class="btn btn-sm btn-warning"
                                        href="index.php?page=3&action=edit&id_p=<?= $unProprietaire['id_p'] ?>">
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
                <?= (isset($lesProprietaires)) ? "Nombre de propriétaires : " . count($lesProprietaires) : "" ?>
            </p>
        </div>
    </div>
</section>

