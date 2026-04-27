
<section>       
        <h1>Identifiez-vous !</h1>
        <?php if(isset($_SESSION['msg-login-resa'])):?>
            <h3 id="msg-login-resa">Veuillez vous connecter ou créer un compte client pour réserver</h3>
        <?php unset($_SESSION['msg-login-resa']);?>
        <?php endif;?>
        <?php if(isset($_SESSION['msg-erreur-connexion'])):?>
                <h3 style="color:red; margin-top: 0.5rem; margin-bottom: 0.5rem; "><?= $_SESSION['msg-erreur-connexion'];?></h3>
        <?php unset($_SESSION['msg-erreur-connexion']);?>
        <?php endif;?>
        <?php if(isset($_SESSION['msg-confirm-changement-mdp'])):?>
                <h3 style="color:green; margin-top: 0.5rem; margin-bottom: 0.5rem; "><?= $_SESSION['msg-confirm-changement-mdp'];?></h3>
        <?php unset($_SESSION['msg-confirm-changement-mdp']);?>
        <?php endif;?>
        <form id="formConnexion" method="post" action="index.php?page=8">
            <table>
                <tr>
                    <td>Email</td>
                    <td><input type="email" name="email" required></td>
                </tr>
                <tr>
                    <td>Mdp</td>
                    <td><input type="password" name="mdp" required></td>
                </tr>
            </table>
                <button class="btnForm" type="submit" name="Connexion" value="Connexion" id="Connexion">
                    <span class="material-symbols-outlined">login</span>
                </button>
                <a href="index.php?page=17" id="lienMdpOublie">Mot de passe oublié ?</a>
                <a href="index.php?page=15" id="creerNouveauCompte" >Créer un nouveau compte</a>
        </form>
</section> 






