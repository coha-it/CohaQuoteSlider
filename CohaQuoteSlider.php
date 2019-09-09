<?php 

namespace CohaQuoteSlider;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\Collections\ArrayCollection;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Theme\LessDefinition;
use Shopware\Components\Plugin\Context\ActivateContext;

class CohaQuoteSlider extends Plugin
{

    public function install(InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');

        $service->update('s_articles_supplier_attributes', 'coha_is_quote_person', 'boolean', [
            'label' => 'Is Quote-Person',
            'helpText' => 'This will give the Supplier some Special Stylings',

            //user has the opportunity to translate the attribute field for each shop
            'translatable' => true,

            //attribute will be displayed in the backend module
            'displayInBackend' => true,

            //numeric position for the backend view, sorted ascending
            'position' => 10,

            //user can modify the attribute in the free text field module
            'custom' => true,
        ]);

        $service->update('s_articles_supplier_attributes', 'coha_quote_classes', 'string', [
            'label' => 'Classes',
            'helpText' => 'Define some special Classes for this Quote',
            'translatable' => true,
            'displayInBackend' => true,
            'position' => 11,
            'custom' => true,
        ]);

        $service->update('s_articles_supplier_attributes', 'coha_quote_html_tags', 'string', [
            'label' => 'HTML-Tags',
            'helpText' => 'Define some HTML-Tags which will wrap this code',
            'translatable' => true,
            'displayInBackend' => true,
            'position' => 12,
            'custom' => true,
        ]);

        $service->update('s_articles_supplier_attributes', 'coha_quote_content', 'html', [
            'label' => 'Quote-Content',
            'helpText' => 'This is the HTML-Content for the Person quoting',
            'translatable' => true,
            'displayInBackend' => true,
            'position' => 16,
            'custom' => true,
        ]);

        $this->update();
    }

    public function update(UpdateContext $context)

        $service = $this->container->get('shopware_attribute.crud_service');

        // Custom URL
        $service->update('s_articles_supplier_attributes', 'coha_url', 'string', [
            'label' => 'URL',
            'helpText' => 'When set, it will replace the URL for each Banner-Slider',
            'translatable' => true,
            'displayInBackend' => true,
            'position' => 20,
            'custom' => true,
        ]);

        // Open URL in New Tab
        $service->update('s_articles_supplier_attributes', 'coha_url_target_blank', 'boolean', [
            'label' => 'URL open in New Tab',
            'helpText' => 'Open the clicked URL in a new Window/Tab',
            'translatable' => true,
            'displayInBackend' => true,
            'position' => 21,
            'custom' => true,
        ]);
    }

    // On Activation
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_articles_supplier_attributes', 'coha_is_quote_person');
        $service->delete('s_articles_supplier_attributes', 'coha_quote_classes');
        $service->delete('s_articles_supplier_attributes', 'coha_quote_html_tags');
        $service->delete('s_articles_supplier_attributes', 'coha_quote_content');
        $service->delete('s_articles_supplier_attributes', 'coha_url');
        $service->delete('s_articles_supplier_attributes', 'coha_url_target_blank');
    }

    public function addLessFiles(){
        return new LessDefinition(
            [],
            [
                __DIR__ . '/Resources/views/frontend/_public/src/less/quoteslider.less',
            ]
        );
    }

    public function onCollectJavascriptFiles()
    {
        $jsFiles = [
            // $this->getPath() . '/Resources/views/frontend/_public/ [...] .js',
        ];
        return new ArrayCollection($jsFiles);
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend' => ['onFrontend',-100],
            'Enlight_Controller_Action_PreDispatch_Widgets' => ['onFrontend',-100],
            'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'onCollectJavascriptFiles',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     * @throws \Exception
     */
    public function onFrontend(\Enlight_Event_EventArgs $args)
    {
        $this->container->get('Template')->addTemplateDir(
            $this->getPath() . '/Resources/views/'
        );
    }

}
