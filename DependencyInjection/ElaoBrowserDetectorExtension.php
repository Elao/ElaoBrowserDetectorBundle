<?php

namespace Elao\Bundle\BrowserDetectorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Browser Detector Bundle Extension
 */
class ElaoBrowserDetectorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $browscapDirective = ini_get('browscap');
        $container->setParameter('elao_browser_detector.browser_detector.parameters.browscap_enabled', !empty($browscapDirective));

        $definition = $container->getDefinition('elao_browser_detector.browser_detector');
        $definition->addMethodCall('loadConfiguration', $config);
    }
}
