<?php

namespace QuoteCMS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPref
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="QuoteCMS\UserBundle\Entity\UserPrefRepository")
 */
class UserPref
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
     * @var boolean
     *
     * @ORM\Column(name="anonymousPost", type="boolean")
     */
    private $anonymousPost = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hideEmail", type="boolean")
     */
    private $hideEmail = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showOnlyPrefGame", type="boolean")
     */
    private $showOnlyPrefGame = false;


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
     * Set anonymousPost
     *
     * @param boolean $anonymousPost
     * @return UserPref
     */
    public function setAnonymousPost($anonymousPost)
    {
        $this->anonymousPost = $anonymousPost;

        return $this;
    }

    /**
     * Get anonymousPost
     *
     * @return boolean
     */
    public function getAnonymousPost()
    {
        return $this->anonymousPost;
    }

    /**
     * Set hideEmail
     *
     * @param boolean $hideEmail
     * @return UserPref
     */
    public function setHideEmail($hideEmail)
    {
        $this->hideEmail = $hideEmail;

        return $this;
    }

    /**
     * Get hideEmail
     *
     * @return boolean
     */
    public function getHideEmail()
    {
        return $this->hideEmail;
    }

    /**
     * Set showOnlyPrefGame
     *
     * @param boolean $showOnlyPrefGame
     * @return UserPref
     */
    public function setShowOnlyPrefGame($showOnlyPrefGame)
    {
        $this->showOnlyPrefGame = $showOnlyPrefGame;

        return $this;
    }

    /**
     * Get showOnlyPrefGame
     *
     * @return boolean
     */
    public function getShowOnlyPrefGame()
    {
        return $this->showOnlyPrefGame;
    }
}
