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
 * @ORM\Table(name="blog_category")
 * @ORM\Entity
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=true)
 */
class Category implements
    IdentityInterface,
    NameableInterface
{
    use IdentityEntity;
    use BlameableEntity;
    use TimestampableEntity;
    use NameableEntity;
    use SoftDeleteableEntity;

    /**
     * Posts
     *
     * @var \Doctrine\Common\Collections\Collection<AppBundle\Entity\Blog\Post>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Blog\Post", mappedBy="categories")
     */
    protected $posts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add post.
     *
     * @param \AppBundle\Entity\Blog\Post $post
     *
     * @return Category
     */
    public function addPost(\AppBundle\Entity\Blog\Post $post)
    {
        if (! $this->posts->contains($post)) {
            $this->posts->add($post);
            $post->addCategory($this);
        }

        return $this;
    }

    /**
     * Remove post.
     *
     * @param \AppBundle\Entity\Blog\Post $post
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePost(\AppBundle\Entity\Blog\Post $post)
    {
        return $this->posts->removeElement($post);
    }

    /**
     * Get posts.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
