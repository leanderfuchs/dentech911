<?php
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;

// PHPMailer Object 
$mail = new PHPMailer;
$mail->IsSMTP ();

// UPDATED CODE -->>
$mail->SMTPAuth   = true;  // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host       = 'smtp.gmail.com';
$mail->Port       = 465; 
$mail->Username   = 'osmose.one.int';
$mail->Password   = 'K7!11O6Sj^7vQxvvkCiy';
$mail->CharSet = 'UTF-8';
// <<-- UPDATED CODE

//Email address to send from
$mail->From = "contact@dentech911.com";
$mail->FromName = "Leander";

//Email address to send to (multiple addresses possible)
$mail->addAddress("leanderfuchs@protonmail.com","test@test.com");

// CC Addresses
//$mail->addCC('test@test.com');
//$mail->addBCC('test@test.com');

// Send as HTML
$mail->IsHTML(true);

// Send attachements
// $mail->addAttachement('path/to/attachement.file');


function build_email_template($main_title, $short_description, $subject, $body, $apropos_title, $apropos_body) {
    // Get email template as string

    $email_template_string = file_get_contents('email_template.html', true);
    
    // Fill email template with message and relevant banner image
    // $email_template = sprintf($email_template_string,'URL_to_Banner_Images/banner_' . $email_subject_image. '.png', $main_title, $short_description, $subject, $body, $apropos_title, $apropos_body );
    $email_template = sprintf($email_template_string, $main_title, $short_description, $subject, $body, $apropos_title, $apropos_body );
    return $email_template;
}


//$email_subject_image = "superimage";
$main_title = "Votre comtpte à été créé";
$short_description = "Bonjour et bienvenu chez DenTech911";
$subject = "Ce que vous avez droit en temps que membre DenTech911";
$body = "Grace à votre compte vous pourrez envoyer des fichers à votre partenaire sans encombrer votre boite mail et en gardant une traçabilié sur le long therme";
$apropos_title = "Dentech911 est une platforme d'échange de fichers. Mais pas que...";
$apropos_body  = "En effet, vous pouvez aussi communiquer avec vos partenaires via la messagerie intégré. Cette messagerie est segmanté pour que les messages correspondent toujours à un cas particulier";

//$final_message = build_email_template($email_subject_image, $main_title, $short_description, $subject, $body, $apropos_title, $apropos_body);
$mail->Subject = "test email";
$mail->Body = build_email_template($main_title, $short_description, $subject, $body, $apropos_title, $apropos_body);
$mail->AltBody = "plain text version";


// -- sending mail and catch errors
if ( ! $mail->send () ) {
    return $mail->ErrorInfo ;
}