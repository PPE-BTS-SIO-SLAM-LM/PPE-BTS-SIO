<section>
    <h1 class="titreGest">Gestion des clients</h1>
    
    <div class="superConteneurGestion">
        <!-- ================= FORMULAIRE (GAUCHE) ================= -->
        <div class="conteneurInsert">
            <h4>Ajouter / Modifier client</h4>

            <form method="post" action="index.php?page=2" class="conteneurFormInsert">
                <table class="tabFormInsert">
                    <tr>
                        <td>Nom</td>
                        <td><input class="formClient" type="text" name="nom"
                            value="<?= ($leClient == null)?"":$leClient['nom'];?>" required></td>
                    </tr>
                    
                    <tr>
                        <td>Prénom</td>
                        <td><input class="formClient" type="text" name="prenom"
                            value="<?= ($leClient == null)?"":$leClient['prenom'];?>" required></td>
                    </tr>

                    <tr>
                        <td>E-mail</td>
                        <td><input class="formClient" type="email" name="email"
                            value="<?= ($leClient == null)?"":$leClient['email'];?>" required></td>
                    </tr>

                    <tr>
                        <td>Mot de passe</td>
                        <td><input class="formClient" type="text" name="mdp"
                            value="<?= ($leClient == null)?"":$leClient['mdp'];?>" required></td>
                    </tr>

                    <tr>
                        <td>Adresse</td>
                        <td><input class="formClient" type="text" name="adresse"
                            value="<?= ($leClient == null)?"":$leClient['adresse'];?>" required></td>
                    </tr>

                    <tr>
                        <td>Code postal</td>
                        <td><input class="formClient" type="text" name="cp"
                            value="<?= ($leClient == null)?"":$leClient['cp'];?>" required></td>
                    </tr>

                    <tr>
                        <td>Ville</td>
                        <td><input class="formClient" type="text" name="ville"
                            value="<?= ($leClient == null)?"":$leClient['ville'];?>" required></td>
                    </tr>

                    <tr>
                        <td>Tél</td>
                        <td><input class="formClient" type="text" name="tel"
                            value="<?= ($leClient == null)?"":$leClient['tel'];?>" required></td>
                    </tr>

                    <tr>
                        <td>RIB</td>
                        <td><input class="formClient" type="text" name="rib"
                            value="<?= ($leClient == null)?"":$leClient['RIB'];?>" required></td>
                    </tr>
                </table>

                    <!-- Erreurs -->
                    <?php if(!empty($_SESSION['msg-erreurs'])): ?>
                        <?php foreach($_SESSION['msg-erreurs'] as $uneErreur): ?>
                            <div class="alert alert-danger p-2"><?= $uneErreur ?></div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['msg-erreurs']); ?>
                    <?php endif; ?>
                    <!-- -->

                    <div class="conteneurBtFormInsert">
                        <button class="btnAnnuler btAnnulerFormInsert" type="submit" name="annuler">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                        <button class="btnValider btValiderFormInsert"
                            type="submit"
                            <?= ($leClient==null)
                                ? 'name="valider"'
                                : 'name="modifier"' ?>>
                            <span class="material-symbols-outlined">check</span>
                        </button>
                    </div>

                <?= ($leClient==null)? '' : '<input type="hidden" name="id_user" value="'.$leClient['id_c'].'">'; ?>
            </form>
        </div> 
        

        <!-- ================= TABLE (DROITE) ================= -->
        <div class="conteneurListe">
            <h4>Liste clients</h4>    
            <div class="conteneurFiltrer">
                <p class="filtrerPar">Filtrer par </p>
                <!-- Filtre -->
                <form method="post" action="index.php?page=2#tabListeClients" class="listes">
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
                    <?php if (isset($lesClients)): ?>
                        <?php foreach ($lesClients as $unClient): ?>
                            <tr>
                                <td><?= $unClient['id_c']; ?></td>
                                <td><?= $unClient['nom']; ?></td>
                                <td><?= $unClient['prenom']; ?></td>
                                <td><?= $unClient['email']; ?></td>
                                <td><?= $unClient['mdp']; ?></td>
                                <td><?= $unClient['adresse']; ?></td>
                                <td><?= $unClient['cp']; ?></td>
                                <td><?= $unClient['ville']; ?></td>
                                <td><?= $unClient['tel']; ?></td>
                                <td><?= $unClient['RIB']; ?></td>

                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                    <td>
                                        <a class="btn btn-sm btn-danger me-1"
                                            href="index.php?page=2&action=sup&id_c=<?= $unClient['id_c'] ?>"
                                            onclick="return confirm('Supprimer ce client ?')">
                                            <span class="material-symbols-outlined btDelete">delete</span>
                                        </a>

                                        <a class="btn btn-sm btn-warning"
                                            href="index.php?page=2&action=edit&id_c=<?= $unClient['id_c'] ?>">
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
                <?= (isset($lesClients)) ? "Nombre de clients : " . count($lesClients) : "" ?>
            </p>
        </div>
    </div>
</section>
