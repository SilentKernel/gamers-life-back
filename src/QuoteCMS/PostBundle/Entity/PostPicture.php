<?php

namespace QuoteCMS\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * PostPicture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="QuoteCMS\PostBundle\Entity\PostPictureRepository")
 * @Gedmo\Uploadable(allowOverwrite=false,appendNumber=true, maxSize=5000000, filenameGenerator="SHA1", allowedTypes="image/gif,image/jpeg,image/png")
 */

class PostPicture
{
    const UPLOADS_DIR = "/media/";

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false, unique=true)
     * @Gedmo\UploadableFileName
     */
    private $filename;

    /**
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @ORM\Column(name="mime_type", type="string")
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

    /**
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     * @ORM\Column(name="to_be_removed", type="boolean")
     */
    private $toBeRemoved = true;

    /**
     * @ORM\ManyToOne(targetEntity="QuoteCMS\PostBundle\Entity\Post", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=true)
     **/
    private $post;

    public function __toString()
    {
        if ($this->getFilename() != "")
            return self::UPLOADS_DIR.$this->getFilename();
        else return null;
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
     * Set mimeType
     *
     * @param string $mimeType
     * @return Avatar
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Avatar
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Avatar
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Avatar
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Set toBeRemoved
     *
     * @param boolean $toBeRemoved
     * @return PostPicture
     */
    public function setToBeRemoved($toBeRemoved)
    {
        $this->toBeRemoved = $toBeRemoved;

        return $this;
    }

    /**
     * Get toBeRemoved
     *
     * @return boolean 
     */
    public function getToBeRemoved()
    {
        return $this->toBeRemoved;
    }

    /**
     * Set post
     *
     * @param \QuoteCMS\PostBundle\Entity\Post $post
     * @return PostPicture
     */
    public function setPost(\QuoteCMS\PostBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \QuoteCMS\PostBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
