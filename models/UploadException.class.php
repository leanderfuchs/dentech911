<?php

class UploadException extends Exception
{
    public function __construct($code) {
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "La taille du fichier est supperieur au 40Mb authorisé par le serveur";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "La taille du fichier est supperieur au 40Mb authorisé par le formulaire";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "Le fichier n'a pas été entièrement envoyé";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "Aucun fichier n'a été reçu";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Le dossier temporaire est manquant";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Erreur d'écriture sur le disque dure du serveur";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "L'extention du fichier non accépté";
                break;

            default:
                $message = "Une erreur non connue c'est produite";
                break;
        }
        return $message;
    }
}
?>