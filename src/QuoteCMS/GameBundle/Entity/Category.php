<?php

namespace QuoteCMS\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="QuoteCMS\GameBundle\Entity\CategoryRepository")
 * @UniqueEntity(fields="name", message="Ce nom existe déjà.")
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
	
    /**
     * @ORM\OneToMany(targetEntity="QuoteCMS\GameBundle\Entity\Game", mappedBy="category")
     */
	private $games;

    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
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
     * Constructor
     */
    public function __construct()
    {
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add games
     *
     * @param \QuoteCMS\GameBundle\Entity\Game $games
     * @return Category
     */
    public function addGame(\QuoteCMS\GameBundle\Entity\Game $games)
    {
        $this->games[] = $games;
        $games->setCategory($this);

        return $this;
    }

    /**
     * Remove games
     *
     * @param \QuoteCMS\GameBundle\Entity\Game $games
     */
    public function removeGame(\QuoteCMS\GameBundle\Entity\Game $games)
    {
        $this->games->removeElement($games);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGames()
    {
        return $this->games;
    }
}
