<?php

namespace Apsylone\ImgixBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Imgix\ShardStrategy;

class ApsyloneImgixExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        if (false === array_key_exists($config['default_source'], $config['sources'])) {
            throw new \InvalidArgumentException('Default source should be one of: ' . implode(', ', array_keys($config['sources'])));
        }
        $container->setParameter('apsylone_imgix.default_source', $config['default_source']);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $extension = $container->getDefinition('apsylone_imgix.twig.url_builder_extension');
        $class = $container->getParameter('apsylone_imgix.url_builder.class');
        foreach ($config['sources'] as $name => $source) {
            $domains = $source['domains'];
            $tls = true;
            $key = $source['secret_url_token'];
            $strategy = 'cycle' === $source['shard_strategy']
                ? ShardStrategy::CYCLE
                : ShardStrategy::CRC;
            $definition = new Definition($class, [$domains, $tls, $key, $strategy]);
            $id = sprintf('apsylone_imgix.url_builder_%s', $name);
            $container->setDefinition($id, $definition);
            $extension->addMethodCall('addBuilder', [$name, new Reference($id)]);
        }
    }
}