<?php

namespace QuoteCMS\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use QuoteCMS\CoreBundle\Entity\ShareCount;


/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="QuoteCMS\PostBundle\Entity\PostRepository")
 */
class Post
{
    private $formUId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="story", type="text")
     */
    private $story;

    /**
     * @var string
     *
     * @ORM\Column(name="videoUrl", type="string", length=255, nullable=true)
     */
    private $videoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="validated", type="boolean", nullable=false)
     */
    private $validated = false;

    /**
     * @var string
     *
     * @ORM\Column(name="anonymous", type="boolean", nullable=false)
     */
    private $anonymous = true;

    /**
     * @var string
     *
     * @ORM\Column(name="plus_one", type="integer", nullable=false)
     */
    private $plusOne = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="least_one", type="integer", nullable=false)
     */
    private $leastOne = 0;

    /**
     * @ORM\OneToOne(targetEntity="QuoteCMS\CoreBundle\Entity\ShareCount",cascade={"persist", "remove"}, fetch="EAGER")
     **/
    private $shareCount;

    /**
     * @var string $createdFromIp
     *
     * @ORM\Column(type="string", length=45, nullable=false)
     */
    private $ip;

	/**
	 * @ORM\ManyToOne(targetEntity="QuoteCMS\GameBundle\Entity\Game", inversedBy="posts", fetch="EAGER")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $game;

    /**
     * @ORM\OneToMany(targetEntity="QuoteCMS\PostBundle\Entity\PostPicture", mappedBy="post", fetch="EAGER")
     **/
    private $pictures;

	/**
	 * @ORM\ManyToOne(targetEntity="QuoteCMS\UserBundle\Entity\User", inversedBy="posts")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $user;

    /**
     * @ORM\ManyToOne(targetEntity="QuoteCMS\DeviceAPIBundle\Entity\DeviceType", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deviceType;

    /**
     * @var string $tempGameName
     *
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $tempGameName;

    /**
     * @ORM\ManyToMany(targetEntity="QuoteCMS\CoreBundle\Entity\Keyword", fetch="EAGER")
     * @ORM\JoinTable(name="quote_keyword")
     */
     private $keywords;

    public function __toString()
    {
        return $this->slug;
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

    /**
     * Set story
     *
     * @param string $story
     * @return Post
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return string
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     * @return Post
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set game
     *
     * @param \QuoteCMS\GameBundle\Entity\Game $game
     * @return Post
     */
    public function setGame(\QuoteCMS\GameBundle\Entity\Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \QuoteCMS\GameBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return Post
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set plusOne
     *
     * @param integer $plusOne
     * @return Post
     */
    public function setPlusOne($plusOne)
    {
        $this->plusOne = $plusOne;

        return $this;
    }

    /**
     * Get plusOne
     *
     * @return integer
     */
    public function getPlusOne()
    {
        return $this->plusOne;
    }

    /**
     * Set leastOne
     *
     * @param integer $leastOne
     * @return Post
     */
    public function setLeastOne($leastOne)
    {
        $this->leastOne = $leastOne;

        return $this;
    }

    /**
     * Get leastOne
     *
     * @return integer
     */
    public function getLeastOne()
    {
        return $this->leastOne;
    }

    /**
     * Set user
     *
     * @param \QuoteCMS\UserBundle\Entity\User $user
     * @return Post
     */
    public function setUser(\QuoteCMS\UserBundle\Entity\User $user)
    {
        $user->addPost($this);
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \QuoteCMS\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set videoUrl
     *
     * @param string $videoUrl
     * @return Post
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    /**
     * Get videoUrl
     *
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * Set anonymous
     *
     * @param boolean $anonymous
     * @return Post
     */
    public function setAnonymous($anonymous)
    {
        $this->anonymous = $anonymous;

        return $this;
    }

    /**
     * Get anonymous
     *
     * @return boolean
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * Add pictures
     *
     * @param \QuoteCMS\PostBundle\Entity\PostPicture $pictures
     * @return Post
     */
    public function addPicture(\QuoteCMS\PostBundle\Entity\PostPicture $pictures)
    {
        $pictures->setPost($this);
        $this->pictures[] = $pictures;
        return $this;
    }

    /**
     * Remove pictures
     *
     * @param \QuoteCMS\PostBundle\Entity\PostPicture $pictures
     */
    public function removePicture(\QuoteCMS\PostBundle\Entity\PostPicture $pictures)
    {
        $this->pictures->removeElement($pictures);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    public function getFormUId()
    {
        return $this->formUId;
    }

    public function setFormUId($formUId)
    {
        $this->formUId = $formUId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Post
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }


    public function setTempGameName($tempGameName)
    {
        $this->tempGameName = $tempGameName;

        return $this;
    }

    public function getTempGameName()
    {
        return $this->tempGameName;
    }

    public function __construct($formUId = null)
    {
        if ($formUId != null)
            $this->formUId = $formUId;
        $this->pictures = new \Doctrine\Common\Collections\ArrayCollection();
        $this->keywords = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shareCount = new ShareCount();
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Post
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set pictures
     *
     * @param \QuoteCMS\PostBundle\Entity\PostPicture $pictures
     * @return Post
     */
    public function setPictures(\QuoteCMS\PostBundle\Entity\PostPicture $pictures = null)
    {
        $this->pictures = $pictures;

        return $this;
    }

    /**
     * Set shareCount
     *
     * @param \QuoteCMS\PostBundle\Entity\ShareCount $shareCount
     * @return Post
     */
    public function setShareCount(\QuoteCMS\CoreBundle\Entity\ShareCount $shareCount = null)
    {
        $this->shareCount = $shareCount;

        return $this;
    }

    /**
     * Get shareCount
     *
     * @return \QuoteCMS\CoreBundle\Entity\ShareCount
     */
    public function getShareCount()
    {
        return $this->shareCount;
    }


    /**
     * Set deviceType
     *
     * @param \QuoteCMS\DeviceAPIBundle\Entity\DeviceType $deviceType
     * @return Post
     */
    public function setDeviceType(\QuoteCMS\DeviceAPIBundle\Entity\DeviceType $deviceType)
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * Get deviceType
     *
     * @return \QuoteCMS\DeviceAPIBundle\Entity\DeviceType
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Add keywords
     *
     * @param \QuoteCMS\CoreBundle\Entity\Keyword $keywords
     * @return Post
     */
    public function addKeyword(\QuoteCMS\CoreBundle\Entity\Keyword $keywords)
    {
        $this->keywords[] = $keywords;

        return $this;
    }

    /**
     * Remove keywords
     *
     * @param \QuoteCMS\CoreBundle\Entity\Keyword $keywords
     */
    public function removeKeyword(\QuoteCMS\CoreBundle\Entity\Keyword $keywords)
    {
        $this->keywords->removeElement($keywords);
    }

    /**
     * Get keywords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
}
