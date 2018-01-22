<?php

namespace QuoteCMS\UserBundle\Avatar;

class AvatarService
{
  private $em;
  private $kernel;

  public function __construct($doctrine, $kernel)
  {
    $this->em = $doctrine->getManager();
    $this->kernel = $kernel;
  }

  public function removeAvatar($user)
  {
    if ($user->getAvatar() != null)
    {
      $avatar = $user->getAvatar();
      $fileName = $avatar->getFileName();
      $basePath = $this->kernel->getRootDir() . "/../web/media/";

      $filePath[] =  $basePath . $fileName;

      // remove avatar and all it's filter
      $filePath[] =  $basePath . "cache/avatar_mini/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_30/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_40/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_50/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_60/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_70/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_80/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_90/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_100/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_110/media/" . $fileName;
      $filePath[] =  $basePath . "cache/avatar_120/media/" . $fileName;

      foreach ($filePath as $oneFilePath) {
        try {
          unlink($oneFilePath);
        }
        catch (\Exception $e)
        {
            // Nothing file does not exist, but try catch prevent Symfony warning in dev
        }
      }

      $user->setAvatar(null);
      $this->em->persist($user);
      $this->em->remove($avatar);
      // Wee flush event if it suck cause that will generate more request, but file already removed so ... we can't keep entity as them old statement
      $this->em->flush();
    }
  }

}
