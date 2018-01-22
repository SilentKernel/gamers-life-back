<?php

namespace Silentkernel\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Topic
 *
 * @ORM\Table(name="topic_comment")
 * @ORM\Entity(repositoryClass="Silentkernel\CommentBundle\Entity\TopicRepository")
 */
class Topic
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
     * @ORM\Column(name="context", type="integer")
     */
    private $context;

    /**
     * @ORM\OneToMany(targetEntity="Silentkernel\CommentBundle\Entity\Comment", mappedBy="topic", cascade={"remove"})
     **/
    private $comments;

    /**
     * @var integer
     *
     * @ORM\Column(name="contextId", type="integer")
     */
    private $contextId;

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
     * Set context
     *
     * @param integer $context
     * @return Topic
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context
     *
     * @return integer 
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set contextId
     *
     * @param integer $contextId
     * @return Topic
     */
    public function setContextId($contextId)
    {
        $this->contextId = $contextId;

        return $this;
    }

    /**
     * Get contextId
     *
     * @return integer 
     */
    public function getContextId()
    {
        return $this->contextId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Add comments
     *
     * @param \Silentkernel\CommentBundle\Entity\Comment $comments
     * @return Topic
     */
    public function addComment(\Silentkernel\CommentBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Silentkernel\CommentBundle\Entity\Comment $comments
     */
    public function removeComment(\Silentkernel\CommentBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
