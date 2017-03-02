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

        $menu->addChild('article', [
            'route' => 'admin_article_index',
            'label' => '文章管理',
            'extras' => [
                'icon' => 'file-text-o',
            ],
        ]);

        return $menu;
    }
}
