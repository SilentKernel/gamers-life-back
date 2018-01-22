<?php

namespace QuoteCMS\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use QuoteCMS\CoreBundle\Entity\ShareCount;

/**
* Article
*
* @ORM\Table(name="blog_article")
* @ORM\Entity(repositoryClass="QuoteCMS\BlogBundle\Entity\ArticleRepository")
*/
class Article
{
  const magicDelimiter = "<!-- preview -->";

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
  * @ORM\Column(name="title", type="string", length=255)
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
   * @var datetime
   *
   * @ORM\Column(name="creation_date", type="datetime")
   * @Gedmo\Timestampable(on="create")
   */
  private $creationDate;

  /**
  * @var string
  *
  * @ORM\Column(name="content", type="text")
  */
  private $content;

  /**
  * @ORM\ManyToOne(targetEntity="QuoteCMS\UserBundle\Entity\User", inversedBy="articles")
  * @ORM\JoinColumn(nullable=false)
  */
  private $user;


  /**
  * @ORM\ManyToMany(targetEntity="QuoteCMS\BlogBundle\Entity\Category", inversedBy="articles", fetch="EAGER")
  * @ORM\JoinTable(name="article_category")
  */
  private $categories;

  /**
   * @ORM\ManyToMany(targetEntity="QuoteCMS\CoreBundle\Entity\Keyword", fetch="EAGER")
   * @ORM\JoinTable(name="article_keyword")
   */
   private $keywords;

   /**
    * @ORM\OneToOne(targetEntity="QuoteCMS\CoreBundle\Entity\ShareCount",cascade={"persist", "remove"}, fetch="EAGER")
    **/
   private $shareCount;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->keywords = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shareCount = new ShareCount();
    }

    public function getShortContent()
    {
      $magicPos = strpos($this->content, self::magicDelimiter);
      if ($magicPos > 0)
      {
        return substr($this->content, 0, $magicPos);
      }
      else
      {
        return $this->content;
      }
    }

    public function getFullContent()
    {
      return str_replace(self::magicDelimiter, "", $this->content);
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
     * Set title
     *
     * @param string $title
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set user
     *
     * @param \QuoteCMS\UserBundle\Entity\User $user
     * @return Article
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
     * Add categories
     *
     * @param \QuoteCMS\BlogBundle\Entity\Category $categories
     * @return Article
     */
    public function addCategory(\QuoteCMS\BlogBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \QuoteCMS\BlogBundle\Entity\Category $categories
     */
    public function removeCategory(\QuoteCMS\BlogBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add keywords
     *
     * @param \QuoteCMS\CoreBundle\Entity\Keyword $keywords
     * @return Article
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

    /**
     * Set shareCount
     *
     * @param \QuoteCMS\CoreBundle\Entity\ShareCount $shareCount
     * @return Article
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
}
