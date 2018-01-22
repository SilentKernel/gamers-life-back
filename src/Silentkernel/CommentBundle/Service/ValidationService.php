<?php
/**
 * Created by PhpStorm.
 * User: Silent
 * Date: 06/08/2015
 * Time: 02:00
 */

namespace Silentkernel\CommentBundle\Service;


class ValidationService
{
    private function thereIsMalicousCode($data)
    {
        $data = strtolower($data);

        // javascript
        if (strpos($data, "<script") !== false)
        {
            return true;
        }
        elseif (strpos($data, "</script>") !== false)
        {
            return true;
        }

        // CSS
        if (strpos($data, "<style") !== false)
        {
            return true;
        }
        elseif (strpos($data, "</style>") !== false)
        {
            return true;
        }

        // iframe
        elseif (strpos($data, "<iframe") !== false)
        {
            return true;
        }
        elseif (strpos($data, "</iframe>") !== false)
        {
            return true;
        }

        // embed
        elseif (strpos($data, "<embed") !== false)
        {
            return true;
        }
        elseif (strpos($data, "</embed>") !== false)
        {
            return true;
        }

        // img
        elseif (strpos($data, "<img") !== false)
        {
            return true;
        }
        elseif (strpos($data, "</img>") !== false)
        {
            return true;
        }

        return false;
    }


    public function isValid($comment)
    {
        $result = array(
            "Status" => "ERROR",
            "Message" => "Une erreur inconnue est survenue"
        );

        if (strlen($comment->getMessage()) < 5 )
        {
            $result["Message"] = "Un commentaire doit faire 5 caractères minimum";
        }
        elseif ($this->thereIsMalicousCode($comment->getMessage()))
        {
            $result["Message"] = "Votre commentaire semble contenir du code HTML";
        }
        elseif (strpos($comment->getMessage(), "http://") !== false ||
            strpos($comment->getMessage(), "https://") !== false ||
            strpos($comment->getMessage(), "www.") !== false)
        {
            $result["Status"] = "INFORMATION";
            $result["Message"] = "Votre commentaire contient un lien, de ce fait il doit être modérer avant d'être afficher sur le site";
        }
        else
        {
            $result["Status"] = "OK";
            $result["Message"] = "Commentaire ajouté, merci";
        }

        return $result;
    }
}
