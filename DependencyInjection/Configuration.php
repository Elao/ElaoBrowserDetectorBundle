<?php

namespace Elao\Bundle\BrowserDetectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Browser Detector Bundle Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('elao_browser_detector');

        $rootNode
            ->children()
                ->arrayNode('browsers')
                    ->children()
                        ->arrayNode('partially_compatible')
                            ->requiresAtLeastOneElement()
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('incompatible')
                            ->requiresAtLeastOneElement()
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
