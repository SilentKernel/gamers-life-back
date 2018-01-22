<?php

namespace QuoteCMS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShareCount
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="QuoteCMS\CoreBundle\Entity\ShareCountRepository")
 */
class ShareCount
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
     * @var integer
     *
     * @ORM\Column(name="facebook", type="integer")
     */
    private $facebook = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="google", type="integer")
     */
    private $google = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="twitter", type="integer")
     */
    private $twitter = 0;


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
     * Set facebook
     *
     * @param integer $facebook
     * @return ShareCount
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return integer
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set google
     *
     * @param integer $google
     * @return ShareCount
     */
    public function setGoogle($google)
    {
        $this->google = $google;

        return $this;
    }

    /**
     * Get google
     *
     * @return integer
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Set twitter
     *
     * @param integer $twitter
     * @return ShareCount
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return integer
     */
    public function getTwitter()
    {
        return $this->twitter;
    }
}
