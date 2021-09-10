<?php

namespace Theme\Containers;

use Plenty\Plugin\Templates\Twig;

class ThemeContainer
{
    /**
     * @param Twig $twig
     * @return string
     */
    public function call(Twig $twig):string
    {
        return $twig->render('Theme::content.Theme');

    }
}