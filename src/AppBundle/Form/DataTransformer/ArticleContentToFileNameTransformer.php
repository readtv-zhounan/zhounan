<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Article;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ArticleContentToFileNameTransformer implements DataTransformerInterface
{
    private $rootDir;
    private $article;

    public function __construct($rootDir, Article $article = null)
    {
        $this->rootDir = $rootDir;
        $this->article = $article;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($filePath)
    {
        if (empty($filePath)) {
            return;
        }

        if (!is_string($filePath)) {
            throw new TransformationFailedException();
        }

        $handle = fopen($filePath, 'r');
        $contents = fread($handle, filesize($filePath));
        fclose($handle);

        return $contents;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string)
    {
        if (!is_string($string)) {
            throw new TransformationFailedException();
        }

        $fileDir = sprintf('%s/var/article/', dirname($this->rootDir));
        if (!file_exists($fileDir)) {
            mkdir($fileDir);
        }

        $tempId = strtoupper(md5(uniqid(mt_rand(), true)));
        $filePath = sprintf('%s%s.txt', $fileDir, $tempId);
        if ($this->article) {
            $filePath = $this->article->getFileName();
        }

        $article = fopen($filePath, 'w');
        fwrite($article, $string);
        fclose($article);

        return $filePath;
    }
}
