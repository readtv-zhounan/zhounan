<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="article")
 */
class Article
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
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $introduction;

    /**
     * @var UploadedFile
     *
     * @ORM\OneToOne(targetEntity="UploadedFile", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $picture;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles", cascade={"persist"})
     */
    private $tags;

    public function __construct($title, $fileName, $introduction, UploadedFile $picture)
    {
        $this->title = $title;
        $this->fileName = $fileName;
        $this->introduction = $introduction;
        $this->picture = $picture;

        $this->tags = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getIntroduction()
    {
        return $this->introduction;
    }

    public function setPicture(UploadedFile $picture)
    {
        $this->picture = $picture;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }
}
