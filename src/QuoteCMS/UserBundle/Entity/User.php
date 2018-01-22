<?php

namespace QuoteCMS\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Criteria;
use QuoteCMS\UserBundle\Entity\UserPref;

/**
* @ORM\Entity
* @ORM\Table(name="FosUser")
*/
class User extends BaseUser
{
  /**
  * @ORM\Id
  * @ORM\Column(type="integer")
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  protected $id;

  /**
  * @var string
  *
  * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=false)
  * @Gedmo\Slug(fields={"username"})
  */
  private $slug;

  /**
  * @var string
  *
  * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
  */
  protected $nickname;

  /**
  * @ORM\Column(name="inscription_date", type="datetime")
  * @Gedmo\Timestampable(on="create")
  */
  protected $inscriptionDate;

  /**
  * @var string
  *
  * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
  */
  protected $facebookId;

  /**
  * @var string
  *
  * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
  */
  protected $googleId;

  /**
  * @var string
  *
  * @ORM\Column(name="twitter_id", type="string", length=255, nullable=true)
  */
  protected $twitterId;

  /**
  * @var string
  *
  * @ORM\Column(name="microsoft_id", type="string", length=255, nullable=true)
  */
  protected $microsoftId;

  /**
  * @var string
  *
  * @ORM\Column(name="twitch_id", type="string", length=255, nullable=true)
  */
  protected $twitchId;

  /**
  * @var string
  *
  * @ORM\Column(name="o_auth", type="boolean", length=255, nullable=false)
  */
  protected $OAuth = false;

  /**
  * @var text
  *
  * @ORM\Column(name="o_auth_acess_token", type="text", nullable=true)
  */
  protected $OAuthAcessToken;

  /**
  * @var string
  *
  * @ORM\Column(name="o_auth_profile_pictures", type="text", nullable=true)
  */
  protected $OAuthProfilePicture;

  /**
  * @ORM\OneToOne(targetEntity="QuoteCMS\UserBundle\Entity\Avatar", fetch="EAGER")
  */
  protected $avatar;

  /**
  * @ORM\OneToOne(targetEntity="QuoteCMS\UserBundle\Entity\UserPref", cascade={"persist", "remove"}, fetch="EAGER")
  * @ORM\JoinColumn(nullable=false)
  */
  protected $pref;

  /**
  * @ORM\OneToMany(targetEntity="QuoteCMS\PostBundle\Entity\Post", mappedBy="user")
  */
  protected $posts;

  /**
  * @ORM\ManyToMany(targetEntity="QuoteCMS\GameBundle\Entity\Game")
  * @ORM\JoinTable(name="FoSUser_pref_Game")
  */
  protected $prefGames;

  /**
  * @ORM\ManyToMany(targetEntity="QuoteCMS\PostBundle\Entity\Post")
  * @ORM\JoinTable(name="FoSUser_seen_Post")
  */
  protected $seenPosts;

  /**
  * @ORM\ManyToMany(targetEntity="QuoteCMS\PostBundle\Entity\Post")
  * @ORM\JoinTable(name="FoSUser_voted_Post")
  */
  protected $votedPosts;


  /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
    $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    $this->seenPosts = new \Doctrine\Common\Collections\ArrayCollection();
    $this->votedPostsPosts = new \Doctrine\Common\Collections\ArrayCollection();
    $this->pref = new UserPref();
  }


  /**
  * Get id
  *
  * @return integer
  */
  public function getId()
  {
    return $this->id;
  }


  public function getOAuthOwner()
  {
    if ($this->facebookId != null)
    return "Facebook";
    elseif ($this->googleId != null)
    return "Google";
    elseif ($this->twitterId != null)
    return "Twitter";
    elseif ($this->microsoftId != null)
    return "Microsoft";
    elseif ($this->twitchId != null)
    return "Twitch";
    else
    return "none";
  }

  /**
  * Get nickname
  *
  * @return string
  */
  public function getNickname()
  {
    if ($this->OAuth)
    {
      return $this->nickname;
    }
    else
    {
      return $this->username;
    }
  }

  /**
  * Set nickname
  *
  * @param string $nickname
  * @return User
  */
  public function setNickname($nickname)
  {
    $this->nickname = $nickname;

    return $this;
  }

  /**
  * Set slug
  *
  * @param string $slug
  * @return User
  */
  public function setSlug($slug)
  {
    $this->slug = $slug;

    return $this;
  }

  /**
  * Get slug
  *
  * @return string
  */
  public function getSlug()
  {
    return $this->slug;
  }

  /**
  * Set facebookId
  *
  * @param string $facebookId
  * @return User
  */
  public function setFacebookId($facebookId)
  {
    $this->facebookId = $facebookId;

    return $this;
  }

  /**
  * Get facebookId
  *
  * @return string
  */
  public function getFacebookId()
  {
    return $this->facebookId;
  }

  /**
  * Set inscriptionDate
  *
  * @param \DateTime $inscriptionDate
  * @return User
  */
  public function setInscriptionDate($inscriptionDate)
  {
    $this->inscriptionDate = $inscriptionDate;

    return $this;
  }

  /**
  * Get inscriptionDate
  *
  * @return \DateTime
  */
  public function getInscriptionDate()
  {
    return $this->inscriptionDate;
  }

  /**
  * Set googleId
  *
  * @param string $googleId
  * @return User
  */
  public function setGoogleId($googleId)
  {
    $this->googleId = $googleId;

    return $this;
  }

  /**
  * Get googleId
  *
  * @return string
  */
  public function getGoogleId()
  {
    return $this->googleId;
  }

  /**
  * Set twitterId
  *
  * @param string $twitterId
  * @return User
  */
  public function setTwitterId($twitterId)
  {
    $this->twitterId = $twitterId;

    return $this;
  }

  /**
  * Get twitterId
  *
  * @return string
  */
  public function getTwitterId()
  {
    return $this->twitterId;
  }

  /**
  * Set
  *
  * @param string $
  * @return User
  */
  public function setMicrosoftId($microsoftId)
  {
    $this->microsoftId = $microsoftId;

    return $this;
  }

  /**
  * Get microsotId
  *
  * @return string
  */
  public function getMicrosoftId()
  {
    return $this->microsoftId;
  }

  /**
  * Set
  *
  * @param string $
  * @return User
  */
  public function setTwitchId($twitchId)
  {
    $this->twitchId = $twitchId;

    return $this;
  }

  /**
  * Get twutchId
  *
  * @return string
  */
  public function getTwitchId()
  {
    return $this->twitchId;
  }

  /**
  * Set OAuth
  *
  * @param boolean $oAuth
  * @return User
  */
  public function setOAuth($oAuth)
  {
    $this->OAuth = $oAuth;

    return $this;
  }

  /**
  * Get OAuth
  *
  * @return boolean
  */
  public function getOAuth()
  {
    return $this->OAuth;
  }

  /**
  * Set OAuthAcessToken
  *
  * @param string $oAuthAcessToken
  * @return User
  */
  public function setOAuthAcessToken($oAuthAcessToken)
  {
    $this->OAuthAcessToken = $oAuthAcessToken;

    return $this;
  }

  /**
  * Get OAuthAcessToken
  *
  * @return string
  */
  public function getOAuthAcessToken()
  {
    return $this->OAuthAcessToken;
  }

  /**
  * Set OAuthProfilePicture
  *
  * @param string $oAuthProfilePicture
  * @return User
  */
  public function setOAuthProfilePicture($oAuthProfilePicture)
  {
    $this->OAuthProfilePicture = $oAuthProfilePicture;

    return $this;
  }

  /**
  * Get OAuthProfilePicture
  *
  * @return string
  */
  public function getOAuthProfilePicture()
  {
    return $this->OAuthProfilePicture;
  }

  /**
  * Set avatar
  *
  * @param \QuoteCMS\UserBundle\Entity\Avatar $avatar
  * @return User
  */
  public function setAvatar(\QuoteCMS\UserBundle\Entity\Avatar $avatar = null)
  {
    $this->avatar = $avatar;

    return $this;
  }

  /**
  * Get avatar
  *
  * @return \QuoteCMS\UserBundle\Entity\Avatar
  */
  public function getAvatar()
  {
    return $this->avatar;
  }

  /**
  * Set pref
  *
  * @param \QuoteCMS\UserBundle\Entity\UserPref $pref
  * @return User
  */
  public function setPref(\QuoteCMS\UserBundle\Entity\UserPref $pref)
  {
    $this->pref = $pref;

    return $this;
  }

  /**
  * Get pref
  *
  * @return \QuoteCMS\UserBundle\Entity\UserPref
  */
  public function getPref()
  {
    return $this->pref;
  }

  /**
  * Add posts
  *
  * @param \QuoteCMS\PostBundle\Entity\Post $posts
  * @return User
  */
  public function addPost(\QuoteCMS\PostBundle\Entity\Post $posts)
  {
    $this->posts[] = $posts;

    return $this;
  }

  /**
  * Remove posts
  *
  * @param \QuoteCMS\PostBundle\Entity\Post $posts
  */
  public function removePost(\QuoteCMS\PostBundle\Entity\Post $posts)
  {
    $this->posts->removeElement($posts);
  }

  /**
  * Get posts
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getPosts()
  {
    return $this->posts;
  }

  /**
  * Add prefGames
  *
  * @param \QuoteCMS\GameBundle\Entity\Game $prefGames
  * @return User
  */
  public function addPrefGame(\QuoteCMS\GameBundle\Entity\Game $prefGames)
  {
    $this->prefGames[] = $prefGames;

    return $this;
  }

  /**
  * Remove prefGames
  *
  * @param \QuoteCMS\GameBundle\Entity\Game $prefGames
  */
  public function removePrefGame(\QuoteCMS\GameBundle\Entity\Game $prefGames)
  {
    $this->prefGames->removeElement($prefGames);
  }

  /**
  * Get prefGames
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getPrefGames()
  {
    return $this->prefGames;
  }

  /**
  * Add seenPosts
  *
  * @param \QuoteCMS\PostBundle\Entity\Post $seenPosts
  * @return User
  */
  public function addSeenPost(\QuoteCMS\PostBundle\Entity\Post $seenPosts)
  {
    $this->seenPosts[] = $seenPosts;

    return $this;
  }

  /**
  * Remove seenPosts
  *
  * @param \QuoteCMS\PostBundle\Entity\Post $seenPosts
  */
  public function removeSeenPost(\QuoteCMS\PostBundle\Entity\Post $seenPosts)
  {
    $this->seenPosts->removeElement($seenPosts);
  }

  /**
  * Get seenPosts
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getSeenPosts()
  {
    return $this->seenPosts;
  }

  /**
  * Add votedPosts
  *
  * @param \QuoteCMS\PostBundle\Entity\Post $votedPosts
  * @return User
  */
  public function addVotedPost(\QuoteCMS\PostBundle\Entity\Post $votedPosts)
  {
    $this->votedPosts[] = $votedPosts;

    return $this;
  }

  /**
  * Remove votedPosts
  *
  * @param \QuoteCMS\PostBundle\Entity\Post $votedPosts
  */
  public function removeVotedPost(\QuoteCMS\PostBundle\Entity\Post $votedPosts)
  {
    $this->votedPosts->removeElement($votedPosts);
  }

  /**
  * Get votedPosts
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getVotedPosts()
  {
    return $this->votedPosts;
  }

  /*
  public function getClearEmail()
  {
    if (!$this->getOAuth())
    {
      return $this->email;
    }
    else
    {
      $underscorePos = strpos($this->email,"_");
      return substr($this->email, $underscorePos+1);
    }
  }
  */

  public function getSSOId()
  {
    return  "gl-" . $this->id;
  }
}
