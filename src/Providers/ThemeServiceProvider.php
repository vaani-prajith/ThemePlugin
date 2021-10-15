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
            $partial->set('header', 'Theme::PageDesign.Header');
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

        //override category item vue component
        $eventDispatcher->listen("IO.Resources.Import", function(ResourceContainer $container)
        {
            $container->addScriptTemplate('Theme::Category.Component.CategoryItem');
        },0);
        //override Addtobasket component
        $eventDispatcher->listen("IO.Resources.Import", function(ResourceContainer $container)
        {
            $container->addScriptTemplate('Theme::Basket.AddToBasket');
        },0);
        //override category page for articles
        $eventDispatcher->listen('IO.tpl.category.item', function(TemplateContainer $container){
            $container->setTemplate('Theme::Category.CategoryItemView.twig');
        }, 0);
        //override category page for content pages
        $eventDispatcher->listen('IO.tpl.category.content', function(TemplateContainer $container){
            $container->setTemplate('Theme::Category.CategoryContent.twig');
        }, 0);
        //override sing-item component
        $eventDispatcher->listen("IO.Resources.Import", function(ResourceContainer $container)
        {
            $container->addScriptTemplate('Theme::Item.Component.SingleItem');
        },0);

        // Override SingleItemView
        $this->overrideTemplate("Ceres::Item.SingleItemWrapper", "Theme::Item.SingleItemWrapper");
        $this->overrideTemplate("Ceres::Item.SingleItemView", "Theme::Item.SingleItemView");
        //Override Collapse widget
        $this->overrideTemplate("Ceres::Widgets.Common.CollapseWidget","Theme::Widgets.CustomCollapseWidget");

    }
}