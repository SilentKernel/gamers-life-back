<?php

namespace QuoteCMS\UserBundle\OAuth;

use FOS\UserBundle\Model\UserInterface as FOSUserInterface;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use QuoteCMS\UserBundle\Entity\Avatar;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class OAuthProvider extends FOSUBUserProvider
{
  CONST FacebookGetPicURL = "https://graph.facebook.com/me?fields=picture.width(500).height(500)&access_token=";
  const MicrosoftGetPicURL = "https://apis.live.net/v5.0/me/picture?type=large&access_token=";
  const UserNameSignKey = "$3rOvOzmxXBaptou+~.W6+]yLudoruHunyZPrudence";

  private $container;

  public function __construct($userManager, $oAuthOwner, $container)
  {
    parent::__construct($userManager, $oAuthOwner);
    $this->container = $container;
  }

  /**
  * {@inheritDoc}
  */
  public function loadUserByOAuthUserResponse(UserResponseInterface $response)
  {
    try {
      return $this->updateUserByOAuthUserResponse(parent::loadUserByOAuthUserResponse($response), $response);
    }
    catch (UsernameNotFoundException $e)
    {
      $user = $this->userManager->findUserByEmail($response->getEmail());
      if ($user != null)
      {
        throw new AccessDeniedHttpException("Désolé, l'adresse email renvoyé par " . ucfirst($response->getResourceOwner()->getName()) . " est déjà utilisé par un autre compte.");
      }
      else
      {
        return $this->createUserByOAuthUserResponse($response, true);
      }
    }
  }

  /**
  * {@inheritDoc}
  */
  public function connect(UserInterface $user, UserResponseInterface $response)
  {
    parent::connect($user, $response);
    /*$providerName = $response->getResourceOwner()->getName();
    $uniqueId = $response->getUsername();
    $user->addOAuthAccount($providerName, $uniqueId);

    $this->userManager->updateUser($user);*/
  }

  protected function createUserByOAuthUserResponse(UserResponseInterface $response, $emailAlreadyUsed = false)
  {
    $user = $this->userManager->createUser();
    // We set the id of the account (google, facebook, whatever)
    $providersetProperty = "set".ucfirst($this->getProperty($response));
    $user->$providersetProperty($response->getUsername());
    // We generate a unique username
    //$user->setUsername($response->getResourceOwner()->getName() . "_" .$response->getUsername());
    $user->setUsername($response->getNickname() . " " . hash("sha256", $response->getResourceOwner()->getName() . "_" . self::UserNameSignKey . "_". $response->getUsername()));

    // Set email
    /*
    if ($response->getResourceOwner()->getName() == "twitter")
    $user->setEmail($response->getNickName()."@twitter.com"); // Twitter, fuck you
    */
    if ($response->getResourceOwner()->getName() == "microsoft") // OH My Fucking GOD !
    {
      /*
      object(HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse)#139 (4) { ["paths":protected]=> array(5) { ["identifier"]=> string(2) "id" ["nickname"]=> string(4) "name" ["realname"]=> string(4) "name" ["email"]=> string(14) "emails.account" ["profilepicture"]=> NULL } ["response":protected]=> array(9) { ["id"]=> string(16) "07491c901db4ad0d" ["name"]=> string(13) "Ludovic Frank" ["first_name"]=> string(7) "Ludovic" ["last_name"]=> string(5) "Frank" ["link"]=> string(25) "https://profile.live.com/" ["gender"]=> NULL ["emails"]=> array(4) { ["preferred"]=> string(22) "silent@silentkernel.fr" ["account"]=> string(22) "silent@silentkernel.fr" ["personal"]
      LOL
      */
      $user->setEmail($response->getResponse()["emails"]["account"]);
    }
    else //
    {
      // Prevent account stealing by SocialLogin
      $user->setEmail($response->getEmail());
    }

    // Set the NickName from oAuth server
    $user->setNickname($response->getNickname());
    // No need to verify email, Ownder already did it
    $user->setEnabled(true);
    // This account is created with OAuth (will be usefull later)
    $user->setOAuth(true);
    // Generate password with random data
    $uniqueData = sha1($response->getResourceOwner()->getName() . $response->getUsername());
    $secret = uniqid(rand(), true). $uniqueData;
    $user->setPlainPassword($secret);

    // Update Oauth information (Avatar, acess token ...) (updateUser is made in this method)
    $user = $this->updateUserByOAuthUserResponse($user, $response);

    return $user;
  }

  /**
  * Attach OAuth sign-in provider account to existing user
  *
  * @param FOSUserInterface      $user
  * @param UserResponseInterface $response
  *
  * @return FOSUserInterface
  */
  protected function updateUserByOAuthUserResponse(FOSUserInterface $user, UserResponseInterface $response)
  {
    if ($user != null)
    {
      // keep the acess Token
      if ($user->getOAuthAcessToken() != $response->getAccessToken()){
        $user->setOAuthAcessToken($response->getAccessToken());
        $this->userManager->updateUser($user, true);
      }

      $oldProfilePictureUrl = $user->getOAuthProfilePicture();

      // Facebook get Profile picture URL
      if ($response->getResourceOwner()->getName() == "facebook")
      {
        $picsJson = json_decode(file_get_contents(self::FacebookGetPicURL . $user->getOAuthAcessToken()), true);
        if (isset($picsJson["picture"]["data"]["url"]))
        {
          $user->setOAuthProfilePicture($picsJson["picture"]["data"]["url"]);
        }
      }
      elseif ($response->getResourceOwner()->getName() == "microsoft")
      {
        $isMicrosoft = true; // LOL YEAH BECAUSE THEY FUCK STANDARD .... !!!!!!!!!!
      }
      else // get Profile Picture (not facebook ...)
      {
        if ($response->getProfilePicture() != null)
        {
          if ($response->getResourceOwner()->getName() == "twitter")
          $user->setOAuthProfilePicture(str_replace("_normal","", $response->getProfilePicture()));
          else
          $user->setOAuthProfilePicture($response->getProfilePicture());
        }
      }

      if ($oldProfilePictureUrl != $user->getOAuthProfilePicture() || isset($isMicrosoft))
      {
        // User changed his profil picture on social Media
        if (isset($isMicrosoft))
        {
          $ProviderPictureUrl = self::MicrosoftGetPicURL . $user->getOAuthAcessToken();
        }
        else
        {
          $ProviderPictureUrl = $user->getOAuthProfilePicture();
        }

        // set the extension of file
        if ((strpos($ProviderPictureUrl, ".jpg") != false) or
        (strpos($ProviderPictureUrl, ".jpeg") != false)
        or isset($isMicrosoft))
        {
          $extension = ".jpg";
        }
        elseif (strpos($ProviderPictureUrl, ".gif") != false){
          $extension = ".gif";
        }
        elseif (strpos($ProviderPictureUrl, ".png") != false){
          $extension = ".png";
        }
        else {
          $extension = "";
        }

        if ($extension != "")
        {
          $tmpPath = "/tmp/". md5($user->getId().time());
          $avatar = new Avatar();
          file_put_contents($tmpPath, file_get_contents($ProviderPictureUrl));
          $fileSize = filesize($tmpPath);

          if (($user->getAvatar() == null) || ($fileSize != $user->getAvatar()->getSize()))
          {
            $file = new UploadedFile($tmpPath,
            "OAuthRemote".$extension,
            null /* Mine Type */,
            $fileSize);

            $this->container->get('stof_doctrine_extensions.uploadable.manager')
            ->markEntityToUpload($avatar, $file);

            $em = $this->container->get('doctrine')->getManager();
            $em->persist($avatar);

            $this->container->get("quotecms_user.avatar_tool")->removeAvatar($user);
            $user->setAvatar($avatar);
            $em->flush();
          }


          $this->userManager->updateUser($user, true);
          if (isset($tmpPath))
          {
            unlink($tmpPath);
          }
        }
      }

      return $user;
    }
    else
    {
      return null;
    }
  }
}
