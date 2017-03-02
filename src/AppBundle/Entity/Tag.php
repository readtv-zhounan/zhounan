<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tag")
 */
class Tag
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="tags")
     * @ORM\JoinTable(name="articletag")
     */
    private $articles;

    public function __construct($name)
    {
        $this->name = $name;

        $this->articles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setArticles(array $articles)
    {
        $this->articles = $articles;

        return $this;
    }

    public function getArticles()
    {
        return $this->articles;
    }

    public function __toString()
    {
        return $this->name;
    }
}
