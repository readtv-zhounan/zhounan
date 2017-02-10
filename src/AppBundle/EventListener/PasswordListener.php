<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Admin;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordListener
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $entities = array_merge($uow->getScheduledEntityInsertions(), $uow->getScheduledEntityUpdates());
        foreach ($entities as $entity) {
            if ($entity instanceof Admin) {
                $password = $this->passwordEncoder
                    ->encodePassword($entity, $entity->getPlainPassword());
                $entity->setPassword($password);

                $userMetadata = $em->getClassMetadata(get_class($entity));
                $uow->recomputeSingleEntityChangeSet($userMetadata, $entity);
            }
        }
    }
}
