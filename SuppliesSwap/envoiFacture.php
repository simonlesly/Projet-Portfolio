<?php
$titre = "Courriel";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class envoiFacture {
    public static function envoyer($membre) {
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $courriel = $_POST["courriel"];


        $message = "Bonjour "  . $nom . "\n" . $prenom . "\n". ", voici votre facture " . $courriel ;



        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP de Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'moussadouc19@gmail.com'; // Remplacez par votre email
            $mail->Password   = 'scpl guwt rfqm';   // Remplacez par votre mot de passe Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Destinataire
            $mail->setFrom('moussadouc19@gmail.com', 'Nom');
            $mail->addAddress('moussadouc19@gmail.com');

            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = "Envoie facture";
            $mail->Body    = $message;

            $mail->send();
            echo 'Message envoyé avec succès';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
        }
    }
}
