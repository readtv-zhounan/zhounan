<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\UploadedFile;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadedFileType extends AbstractType
{
    private $uploadableManager;

    public function __construct(UploadableManager $uploadableManager)
    {
        $this->uploadableManager = $uploadableManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fileOptions = $options['file_options'];
        $fileOptions['mapped'] = false;

        $builder
            ->add('file', Type\FileType::class, $fileOptions)
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $entity = $event->getData();

                $fileInfo = $form->get('file')->getData();
                if (null !== $fileInfo) {
                    $this->uploadableManager->markEntityToUpload($entity, $fileInfo);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UploadedFile::class,
            'file_options' => [],
        ]);
    }
}
