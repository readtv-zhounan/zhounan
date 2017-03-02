<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagsToStringTransformer implements DataTransformerInterface
{
    private $tagRepository;

    public function __construct(EntityRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($array)
    {
        if (null === $array) {
            return '';
        }

        if (!$array instanceof Collection) {
            throw new TransformationFailedException();
        }

        if (0 === $array->count()) {
            return '';
        }

        return implode(',', array_map(function (Tag $tag) {
            return $tag->getName();
        }, $array->toArray()));
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string)
    {
        if (null === $string) {
            return [];
        }

        if (!is_string($string)) {
            throw new TransformationFailedException();
        }

        $tags = explode(',', $string);

        $existTags = $this->tagRepository
            ->createQueryBuilder('t')
            ->where('t.name IN (:tags)')
            ->setParameters(compact('tags'))
            ->getQuery()
            ->getResult()
        ;

        $existTagNames = array_map(function (Tag $tag) {
            return $tag->getName();
        }, $existTags);

        $newTagNames = array_diff($tags, $existTagNames);
        foreach ($newTagNames as $newTagName) {
            $existTags[] = new Tag($newTagName);
        }

        return $existTags;
    }
}
