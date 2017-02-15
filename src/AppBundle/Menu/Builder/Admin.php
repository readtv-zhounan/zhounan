<?php

namespace AppBundle\Menu\Builder;

use Knp\Menu\FactoryInterface;

class Admin
{
    public function sidebar(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', [
            'childrenAttributes' => [
                'id' => 'side-menu',
                'class' => 'nav',
            ],
        ]);

        $menu->addChild('home', [
            'route' => 'admin_home',
            'label' => '控制台',
            'extras' => [
                'icon' => 'dashboard',
            ],
        ]);

        return $menu;
    }
}
