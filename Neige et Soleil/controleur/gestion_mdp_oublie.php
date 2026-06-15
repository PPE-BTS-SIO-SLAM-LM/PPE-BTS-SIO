<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../PHPMailer-master/src/Exception.php";
require_once __DIR__ . "/../PHPMailer-master/src/PHPMailer.php";
require_once __DIR__ . "/../PHPMailer-master/src/SMTP.php";


$erreurs = [];

    if(isset($_POST['annuler'])){
        header("Location:index.php?page=8");
        exit;
    }

    if(isset($_POST['verifier'])){
        $email = trim($_POST['email']);
        $compte_exist = $unControleur->selectWhereEmailUtilisateur($email);

        $regexEmail = '/^[A-Za-zÀ-ÖØ-öø-ÿ0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/u';

        if($email == ""){
            $erreurs[] = "Veuillez indiquer votre email";
        }elseif(!preg_match($regexEmail,$email)){
            $erreurs[] = "Veuillez saisir un email valide";
        }
        elseif($compte_exist == null){
            $erreurs[] = "Aucun compte associé a cet email";
        }
        

        
        if(!empty($erreurs)){
            $_SESSION['msg-erreur'] = $erreurs;
        }
        else{
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $unControleur->resetCode($email,$code);

            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';

            $mail->SMTPOptions = array('ssl' => array(
                                                'verify_peer' => false,
                                                'verify_peer_name' => false,
                                                'allow_self_signed' => true
                                                )
                                            );
            try {
                // Paramètres Serveur (gmail)
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'neigeetsoleil2026@gmail.com';
                $mail->Password   = 'kgwxwfhtewtlhgce'; // mdp application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Destinataires
                $mail->setFrom('neigeetsoleil2026@gmail.com', 'Neige et soleil');
                $mail->addAddress($email);

                // Contenu
                $mail->isHTML(true);
                $mail->Subject = 'Votre code de réinitialisation';
                $mail->Body    = "Votre code est : <b>$code</b>. Il est valable 15 minutes.";

                $mail->send();

                // Stockage email en session pour la page suivante
                $_SESSION['email_reset'] = $email;
                header("Location: index.php?page=18");
                exit;

            } catch (Exception $e) {
                $_SESSION['msg-erreur'] = ["L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}"];
            }
        }
    }

    require_once("vue/vue_mdp_oublie.php");
?>