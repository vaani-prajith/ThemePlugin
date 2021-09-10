<?php

namespace Theme\Providers;


use IO\Extensions\Functions\Partial;
use Plenty\Modules\Catalog\Contracts\TemplateContainerContract;
use Plenty\Modules\Webshop\Template\Providers\TemplateServiceProvider;
use IO\Helper\TemplateContainer;
use IO\Helper\ResourceContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;


/**
 * Class ThemeServiceProvider
 * @package Theme\Providers
 */
class ThemeServiceProvider extends TemplateServiceProvider
{
    /**
    * Register the route service provider
    */
    public function register()
    {

    }

    public function boot(Twig $twig, Dispatcher $eventDispatcher)
    {
        $eventDispatcher->listen('IO.init.templates', function(Partial $partial)
        {
            $partial->set('footer', 'Theme::content.ThemeFooter');
            $partial->set('page-design', 'Ceres::PageDesign.PageDesign');
            return false;
        }, 0);

        //Override basket content
        $eventDispatcher->listen('IO.tpl.basket', function (TemplateContainer $container, $templateData){
            $container->setTemplate('Theme::content.ThemeBasket');
            return false;
        }, 0);

        //Home page
        $eventDispatcher->listen('IO.tpl.home.category', function (TemplateContainer $container, $templateData){
            $container->setTemplate('Theme::HomePage.Homepage');
            return false;
        }, 0);

        // Override VUE Template
        $eventDispatcher->listen("IO.Resources.Import", function(ResourceContainer $container)
        {
            $container->addScriptTemplate('Theme::Item.Components.SingleItem');
        }, 0);

        // Override SingleItemView
        $this->overrideTemplate("Ceres::Item.SingleItemWrapper", "Theme::Item.SingleItemWrapper");
        $this->overrideTemplate("Ceres::Item.SingleItemView", "Theme::Item.SingleItemView");
        //Override Collapse widget
        $this->overrideTemplate("Ceres::Widgets.Common.CollapseWidget","Theme::Widgets.CustomCollapseWidget");

    }
}