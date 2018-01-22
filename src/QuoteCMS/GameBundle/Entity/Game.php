<?php

namespace QuoteCMS\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Game
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="QuoteCMS\GameBundle\Entity\GameRepository")
 * @UniqueEntity(fields="name", message="Ce nom de  jeu existe déjà.")
 */
class Game
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
	 * @ORM\ManyToOne(targetEntity="QuoteCMS\GameBundle\Entity\Category", inversedBy="games", fetch="EAGER")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $category;
	
    /**
     * @ORM\OneToMany(targetEntity="QuoteCMS\PostBundle\Entity\Post", mappedBy="game")
     */
	private $posts;

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
     * @return Game
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
     * @return Game
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
     * Set category
     *
     * @param \QuoteCMS\GameBundle\Entity\Category $category
     * @return Game
     */
    public function setCategory(\QuoteCMS\GameBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \QuoteCMS\GameBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add posts
     *
     * @param \QuoteCMS\PostBundle\Entity\Post $posts
     * @return Game
     */
    public function addPost(\QuoteCMS\PostBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
        $posts->setGame($this);

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

    public function __toString()
    {
        return $this->name;
    }

    public function getPostCount()
    {
        return $this->posts->count();
    }
}
