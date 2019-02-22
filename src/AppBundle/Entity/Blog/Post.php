<?php

namespace AppBundle\Entity\Blog;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use AppBundle\Model\Blameable\BlameableEntity;
use AppBundle\Model\SoftDeleteableEntity;
use AppBundle\Model\Timestampable\TimestampableEntity;
use AppBundle\Model\{IdentityInterface, IdentityEntity};
use AppBundle\Model\{NameableInterface, NameableEntity};

/**
 * Blog Post
 *
 * @ORM\Table(name="blog_post")
 * @ORM\Entity
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=true)
 */
class Post implements
    IdentityInterface,
    NameableInterface
{
    use IdentityEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use NameableEntity;
    use SoftDeleteableEntity;

    /**
     * Body (content)
     *
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    protected $body;

    /**
     * Draft
     *
     * @var boolean
     *
     * @ORM\Column(name="draft", type="boolean")
     */
    protected $draft = false;

    /**
     * Categories
     *
     * @var \Doctrine\Common\Collections\Collection<AppBundle\Entity\Category>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Blog\Category", inversedBy="posts")
     * @ORM\JoinTable(
     *     name="blog_posts_categories",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    protected $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set body.
     *
     * @param string $body
     *
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set draft.
     *
     * @param bool $draft
     *
     * @return Post
     */
    public function setDraft($draft)
    {
        $this->draft = $draft;

        return $this;
    }

    /**
     * Get draft.
     *
     * @return bool
     */
    public function isDraft()
    {
        return $this->draft;
    }

    /**
     * Add category.
     *
     * @param \AppBundle\Entity\Blog\Category $category
     *
     * @return Post
     */
    public function addCategory(\AppBundle\Entity\Blog\Category $category)
    {
        if (! $this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addPost($this);
        }

        return $this;
    }

    /**
     * Remove category.
     *
     * @param \AppBundle\Entity\Blog\Category $category
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCategory(\AppBundle\Entity\Blog\Category $category)
    {
        return $this->categories->removeElement($category);
    }

    /**
     * Get categories.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
