<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Article;
use AppBundle\Form\DataTransformer\ArticleContentToFileNameTransformer;
use AppBundle\Form\DataTransformer\TagsToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class ArticleType extends AbstractType
{
    private $rootDir;
    private $article;
    private $tagRepository;

    public function __construct($tagRepository, $rootDir, Article $article = null)
    {
        $this->tagRepository = $tagRepository;
        $this->rootDir = $rootDir;
        $this->article = $article;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('fileName', Type\TextareaType::class)
            ->add('introduction')
            ->add('tags', Type\TextType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
                $entity = $event->getData();
                $form = $event->getForm();

                $isNew = null === $entity || null === $entity->getId();
                $form->add('picture', UploadedFileType::class, [
                    'required' => $isNew,
                    'file_options' => [
                        'constraints' => [new Constraints\File(['maxSize' => '200k'])],
                    ],
                ]);
            });

        $builder->get('fileName')->addModelTransformer(
            new ArticleContentToFileNameTransformer($this->rootDir, $this->article)
        );
        $builder->get('tags')->addModelTransformer(
            new TagsToStringTransformer($this->tagRepository)
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'empty_data' => function (FormInterface $form) {
                return new Article(
                    $form->get('title')->getData(),
                    $form->get('fileName')->getData(),
                    $form->get('introduction')->getData(),
                    $form->get('picture')->getData()
                );
            },
        ]);
    }
}
