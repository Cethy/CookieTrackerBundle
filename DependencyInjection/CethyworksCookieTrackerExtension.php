<?php

namespace Cethyworks\CookieTrackerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CethyworksCookieTrackerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadFromTracker($container, $config['from_simple_tracker']);
    }

    /**
     * Enable & load services for the "from" simple tracker
     */
    public function loadFromTracker(ContainerBuilder $container, array $config)
    {

        if(! $config['enabled'])
        {
            return;
        }

        $container->setParameter('cethyworks_cookie_tracker.from_simple_tracker.get_parameter', $config['get_parameter']);
        $container->setParameter('cethyworks_cookie_tracker.from_simple_tracker.cookie.name', $config['cookie']['name']);
        $container->setParameter('cethyworks_cookie_tracker.from_simple_tracker.cookie.expire', $config['cookie']['expire']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/extra'));
        $loader->load('from_simple_tracker.yml');
    }
}
