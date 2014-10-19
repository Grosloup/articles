<?php

namespace ZPB\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Post
 *
 * @ORM\Table(name="zpb_posts")
 * @ORM\Entity(repositoryClass="ZPB\AdminBundle\Entity\PostRepository")
 */
class Post
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
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(name="excerpt", type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="ZPB\AdminBundle\Entity\PostCategory", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="ZPB\AdminBundle\Entity\PostTag", inversedBy="posts")
     * @ORM\JoinTable(name="zpb_posts_tags")
     */
    private $tags;

    /**
     * @ORM\Column(name="image_bandeau_id", type="integer", nullable=true)
     */
    private $bandeau;

    /**
     * @ORM\Column(name="squarre_thumb_id", type="integer", nullable=true)
     */
    private $squarreThumb;
    /**
     * @ORM\Column(name="fb_thumb_id", type="integer", nullable=true)
     */
    private $fbThumb;



    /**
     * @var boolean
     *
     * @ORM\Column(name="is_published", type="boolean")
     */
    private $isPublished;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_draft", type="boolean")
     */
    private $isDraft;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_dropped", type="boolean")
     */
    private $isDropped;

    /**
     * @ORM\Column(name="targets", type="array", nullable=true)
     */
    private $targets;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->isPublished = false;
        $this->isDraft = true;
        $this->isDropped = false;
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
     * Set body
     *
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }



    /**
     * Set category
     *
     * @param PostCategory $category
     * @return Post
     */
    public function setCategory(PostCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return PostCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tags
     *
     * @param PostTag $tags
     * @return Post
     */
    public function addTag(PostTag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param PostTag $tags
     */
    public function removeTag(PostTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     * @return Post
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set bandeau
     *
     * @param integer $bandeau
     * @return Post
     */
    public function setBandeau($bandeau)
    {
        $this->bandeau = $bandeau;

        return $this;
    }

    /**
     * Get bandeau
     *
     * @return integer
     */
    public function getBandeau()
    {
        return $this->bandeau;
    }

    /**
     * Set squarreThumb
     *
     * @param integer $squarreThumb
     * @return Post
     */
    public function setSquarreThumb($squarreThumb)
    {
        $this->squarreThumb = $squarreThumb;

        return $this;
    }

    /**
     * Get squarreThumb
     *
     * @return integer
     */
    public function getSquarreThumb()
    {
        return $this->squarreThumb;
    }

    /**
     * Set fbThumb
     *
     * @param integer $fbThumb
     * @return Post
     */
    public function setFbThumb($fbThumb)
    {
        $this->fbThumb = $fbThumb;

        return $this;
    }

    /**
     * Get fbThumb
     *
     * @return integer
     */
    public function getFbThumb()
    {
        return $this->fbThumb;
    }

    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     * @return Post
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set isDraft
     *
     * @param boolean $isDraft
     * @return Post
     */
    public function setIsDraft($isDraft)
    {
        $this->isDraft = $isDraft;

        return $this;
    }

    /**
     * Get isDraft
     *
     * @return boolean
     */
    public function getIsDraft()
    {
        return $this->isDraft;
    }

    /**
     * Set isDropped
     *
     * @param boolean $isDropped
     * @return Post
     */
    public function setIsDropped($isDropped)
    {
        $this->isDropped = $isDropped;

        return $this;
    }

    /**
     * Get isDropped
     *
     * @return boolean
     */
    public function getIsDropped()
    {
        return $this->isDropped;
    }

    /**
     * Set targets
     *
     * @param array $targets
     * @return Post
     */
    public function setTargets($targets)
    {
        $this->targets = $targets;

        return $this;
    }

    /**
     * Get targets
     *
     * @return array
     */
    public function getTargets()
    {
        return $this->targets;
    }
}
