<?php

namespace AppBundle\Command;

use AppBundle\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AdminCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:admin:create')
            ->setDescription('创建管理员')
            ->setDefinition([
                new InputArgument('username', InputArgument::REQUIRED, '用户名'),
                new InputArgument('password', InputArgument::REQUIRED, '密码'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $username = $input->getArgument('username');
        $plainPassword = $input->getArgument('password');

        $admin = new Admin($username, $plainPassword);

        $em = $container->get('doctrine.orm.entity_manager');

        $em->persist($admin);
        $em->flush();
    }
}
