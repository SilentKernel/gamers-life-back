<?php

namespace QuoteCMS\CoreBundle\Service;


class UploadValidator
{
    public function isValid($file, $type = "avatar")
    {
        $result["success"] = true;

        // Size validation
        if (($type == "avatar" && $file->getClientSize() > 2000000)
            or ($type == "postImage" && $file->getClientSize() > 5000000))
        {
            $result["success"] = false;
            $result["message"] = "Ce fichier dépasse la taille autorisée";
            return $result;
        }

        // Renaming process will use original file extension to rename file in server
        // if original file's extension is .php the process wil move it to .php (That's crap ye)
        $extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

        if (($extension != "png")
            && ($extension != "jpg")
            && ($extension != "jpeg")
            && ($extension != "gif"))
        {
            $result["success"] = false;
            $result["message"] = "Ce fichier n'est pas une image.";
            return $result;
        }

        // Check the type of file
        if ($file->getClientMimeType() != "image/jpeg"
            && $file->getClientMimeType() != "image/png"
            && $file->getClientMimeType() != "image/gif")
        {
            $result["success"] = false;
            $result["message"] = "Impossible de déterminer la structure de ce fichier";
        }

        return $result;
    }
}