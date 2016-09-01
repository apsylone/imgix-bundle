<?php

namespace Apsylone\ImgixBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('apsylone_imgix');
        $rootNode
            ->children()
                ->scalarNode('default_source')
                    ->defaultValue('default')
                ->end()
                ->arrayNode('sources')
                ->requiresAtLeastOneElement()
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->arrayNode('domains')
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->prototype('scalar')
                            ->end()
                        ->end()
                        ->scalarNode('secret_url_token')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('shard_strategy')
                            ->defaultValue('crc')
                            ->validate()
                            ->ifNotInArray(array('crc', 'cycle'))
                                ->thenInvalid('Invalid shard strategy "%s"')
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->end()
                ->arrayNode('filter_sets')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->fixXmlConfig('filter', 'filters')
                    ->children()
                        ->arrayNode('filters')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->useAttributeAsKey('name')
                                ->prototype('variable')->end()
                                ->children()
                                    ->scalarNode('bri')->defaultValue(0)->end()
                                    ->scalarNode('con')->defaultValue(0)->end()
                                    ->scalarNode('exp')->defaultValue(0)->end()
                                    ->scalarNode('gam')->defaultValue(0)->end()
                                    ->scalarNode('high')->defaultValue(0)->end()
                                    ->scalarNode('hue')->defaultValue(0)->end()
                                    ->scalarNode('invert')->defaultValue(0)->end()
                                    ->scalarNode('sat')->defaultValue(0)->end()
                                    ->scalarNode('shad')->defaultValue(0)->end()
                                    ->scalarNode('sharp')->defaultValue(0)->end()
                                    ->scalarNode('usm')->defaultValue(0)->end()
                                    ->scalarNode('usmrad')->defaultValue(2.5)->end()
                                    ->scalarNode('vib')->defaultValue(0)->end()
                                    ->scalarNode('bg')->defaultValue('0FFF')->end()
                                    ->scalarNode('crop')->defaultNull()->end()
                                    ->scalarNode('h')->defaultNull()->end()
                                    ->scalarNode('w')->defaultNull()->end()
                                    ->scalarNode('fit')->defaultNull()->end()
                                    ->scalarNode('rect')->defaultNull()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}