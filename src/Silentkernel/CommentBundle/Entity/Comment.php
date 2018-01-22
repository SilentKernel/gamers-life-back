<?php

namespace Silentkernel\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Silentkernel\CommentBundle\Entity\CommentRepository")
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Silentkernel\CommentBundle\Entity\Topic", inversedBy="comments", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $topic;

    /**
     * @ORM\ManyToOne(targetEntity="QuoteCMS\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="plus_one", type="integer")
     */
    private $plusOne = 0;

    /**
     * @ORM\Column(name="creation_date", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Silentkernel\CommentBundle\Entity\Comment")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parentComment;

    /**
     * @ORM\ManyToMany(targetEntity="QuoteCMS\UserBundle\Entity\User")
     */
    private $usersVote;

    /**
     * @ORM\ManyToOne(targetEntity="QuoteCMS\DeviceAPIBundle\Entity\DeviceType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $deviceType;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_adress", type="string")
     */
    private $ipAdress;

    /**
     * @var bool
     *
     * @ORM\Column(name="validated", type="boolean")
     */
    private $validated = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted_by_user", type="boolean")
     */
    private $deletedByUser = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted_by_moderation", type="boolean")
     */
    private $deletedByModeration = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="edited_by_user", type="boolean")
     */
    private $editedByUser = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="edited_by_moderation", type="boolean")
     */
    private $editedByModeration = false;

    /**
     * @ORM\Column(type="integer")
     */
     private $reportCount = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=false)
     */
    private $message;

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
     * Set message
     *
     * @param string $message
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set topic
     *
     * @param \Silentkernel\CommentBundle\Entity\Topic $topic
     * @return Comment
     */
    public function setTopic(\Silentkernel\CommentBundle\Entity\Topic $topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \Silentkernel\CommentBundle\Entity\Topic
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set user
     *
     * @param \QuoteCMS\UserBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\QuoteCMS\UserBundle\Entity\User $user)
    {
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
     * Set plusOne
     *
     * @param integer $plusOne
     * @return Comment
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Comment
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
     * Set parentComment
     *
     * @param \Silentkernel\CommentBundle\Entity\Comment $parentComment
     * @return Comment
     */
    public function setParentComment(\Silentkernel\CommentBundle\Entity\Comment $parentComment = null)
    {
        $this->parentComment = $parentComment;

        return $this;
    }

    /**
     * Get parentComment
     *
     * @return \Silentkernel\CommentBundle\Entity\Comment
     */
    public function getParentComment()
    {
        return $this->parentComment;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usersVote = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add usersVote
     *
     * @param \QuoteCMS\UserBundle\Entity\User $usersVote
     * @return Comment
     */
    public function addUsersVote(\QuoteCMS\UserBundle\Entity\User $usersVote)
    {
        $this->usersVote[] = $usersVote;

        return $this;
    }

    /**
     * Remove usersVote
     *
     * @param \QuoteCMS\UserBundle\Entity\User $usersVote
     */
    public function removeUsersVote(\QuoteCMS\UserBundle\Entity\User $usersVote)
    {
        $this->usersVote->removeElement($usersVote);
    }

    /**
     * Get usersVote
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersVote()
    {
        return $this->usersVote;
    }

    /**
     * Set deviceType
     *
     * @param \QuoteCMS\DeviceAPIBundle\Entity\DeviceType $deviceType
     * @return Comment
     */
    public function setDeviceType(\QuoteCMS\DeviceAPIBundle\Entity\DeviceType $deviceType = null)
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
     * Set ipAdress
     *
     * @param string $ipAdress
     * @return Comment
     */
    public function setIpAdress($ipAdress)
    {
        $this->ipAdress = $ipAdress;

        return $this;
    }

    /**
     * Get ipAdress
     *
     * @return string
     */
    public function getIpAdress()
    {
        return $this->ipAdress;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return Comment
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
     * Set deletedByUser
     *
     * @param boolean $deletedByUser
     * @return Comment
     */
    public function setDeletedByUser($deletedByUser)
    {
        $this->deletedByUser = $deletedByUser;

        return $this;
    }

    /**
     * Get deletedByUser
     *
     * @return boolean
     */
    public function getDeletedByUser()
    {
        return $this->deletedByUser;
    }

    /**
     * Set deletedByModeration
     *
     * @param boolean $deletedByModeration
     * @return Comment
     */
    public function setDeletedByModeration($deletedByModeration)
    {
        $this->deletedByModeration = $deletedByModeration;

        return $this;
    }

    /**
     * Get deletedByModeration
     *
     * @return boolean
     */
    public function getDeletedByModeration()
    {
        return $this->deletedByModeration;
    }

    /**
     * Set editedByUser
     *
     * @param boolean $editedByUser
     * @return Comment
     */
    public function setEditedByUser($editedByUser)
    {
        $this->editedByUser = $editedByUser;

        return $this;
    }

    /**
     * Get editedByUser
     *
     * @return boolean
     */
    public function getEditedByUser()
    {
        return $this->editedByUser;
    }

    /**
     * Set editedByModeration
     *
     * @param boolean $editedByModeration
     * @return Comment
     */
    public function setEditedByModeration($editedByModeration)
    {
        $this->editedByModeration = $editedByModeration;

        return $this;
    }

    /**
     * Get editedByModeration
     *
     * @return boolean
     */
    public function getEditedByModeration()
    {
        return $this->editedByModeration;
    }

    /**
     * Set reportCount
     *
     * @param integer $reportCount
     * @return Comment
     */
    public function setReportCount($reportCount)
    {
        $this->reportCount = $reportCount;

        return $this;
    }

    /**
     * Get reportCount
     *
     * @return integer
     */
    public function getReportCount()
    {
        return $this->reportCount;
    }

    function isDeleted()
    {
        return ($this->deletedByUser or $this->deletedByModeration);
    }
}
