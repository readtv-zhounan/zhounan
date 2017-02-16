<?php

namespace AppBundle\Menu\Renderer;

use Knp\Menu\ItemInterface;
use Knp\Menu\Renderer\ListRenderer;

class Sidebar extends ListRenderer
{
    protected function renderLinkElement(ItemInterface $item, array $options)
    {
        return sprintf(
            '<a href="%s"%s>%s %s</a>',
            $this->escape($item->getUri()),
            $this->renderHtmlAttributes($item->getLinkAttributes()),
            $this->renderIcon($item),
            $this->renderLabel($item, $options)
        );
    }

    protected function renderIcon(ItemInterface $item)
    {
        $icon = $item->getExtra('icon');
        if (null === $icon) {
            return '';
        }

        return sprintf('<i class="fa fa-%s fa-fw"></i>', $icon);
    }
}
