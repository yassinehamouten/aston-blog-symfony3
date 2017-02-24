<?php

namespace yh\postBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Posts
 *
 * 
 * @ORM\Entity
 *
 * @ORM\Table(name = "posts")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="yh\postBundle\Repository\PostsRepository")
 */
class Posts {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="contenthtml", type="text")
     */
    private $contenthtml;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="text")
     */
    private $author;

    /**
     * Just a property which is not a doctrine mapped property
     */
    private $temp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $extension;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="yh\blogBundle\Entity\users")
     */
    protected $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Posts
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Posts
     */
    public function setSummary($summary) {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary() {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Posts
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Posts
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Posts
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set user
     *
     * @param \yh\blogBundle\Entity\users $user
     *
     * @return Posts
     */
    public function setUser(\yh\blogBundle\Entity\users $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \yh\blogBundle\Entity\users
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set contenthtml
     *
     * @param string $contenthtml
     *
     * @return Posts
     */
    public function setContenthtml($contenthtml) {
        $this->contenthtml = $contenthtml;

        return $this;
    }

    /**
     * Get contenthtml
     *
     * @return string
     */
    public function getContenthtml() {
        return $this->contenthtml;
    }

    /**
     * Set extension
     *
     * @param string $extension
     *
     * @return Posts
     */
    public function setExtension($extension) {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension() {
        return $this->extension;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    public function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/pictures';
    }

    public function getAbsolutePath() {
        return null === $this->extension ? null : $this->getUploadRootDir() . '/' . $this->id . '.' . $this->extension;
    }

    /**
     * Get file.
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Sets file.
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
        if (is_file($this->getAbsolutePath())) {
            $this->temp = $this->getAbsolutePath();
            $this->extension = null;
        } else {
            $this->extension = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->getFile()) {
            $this->extension = $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null === $this->getFile()) {
            return;
        }
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->getFile()->move(
                $this->getUploadRootDir(), $this->id . '.' . $this->getFile()->guessExtension()
        );
        $this->setFile(null);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove() {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    public function getImage() {
        return $this->id . '.' . $this->extension;
    }

}
