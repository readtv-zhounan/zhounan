<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Uploadable\FileInfo\FileInfoInterface;

/**
 * Uploaded File
 *
 * @Gedmo\Uploadable(filenameGenerator="SHA1", allowOverwrite=true)
 * @ORM\Entity
 * @ORM\Table(name="uploadedfile")
 */
class UploadedFile implements FileInfoInterface
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @Gedmo\UploadableFileName
     * @ORM\Column(type="string")
     */
    private $name;

    private $tmpName;

    /**
     * @var string
     *
     * @Gedmo\UploadableFileMimeType
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @var float
     *
     * @Gedmo\UploadableFileSize
     * @ORM\Column(type="decimal")
     */
    private $size;

    /**
     * @var string
     *
     * @Gedmo\UploadableFilePath
     * @ORM\Column(type="string")
     */
    protected $path;

    public function getId()
    {
        return $this->id;
    }

    public function getTmpName()
    {
        return $this->tmpName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getError()
    {
    }

    public function isUploadedFile()
    {
        return true;
    }
}
