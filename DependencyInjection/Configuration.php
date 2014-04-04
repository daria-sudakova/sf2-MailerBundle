<?php

namespace Umbrellaweb\Bundle\MailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 * 
 * @author Umbrella-web <http://umbrella-web.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('umbrellaweb_mailer');

        $rootNode
                ->children()
                    ->scalarNode('charset')
                        ->defaultValue('utf-8')
                        ->end()
                   
                    ->scalarNode('content_type')
                        ->defaultValue('text/html')
                        ->end()
                  
                    ->scalarNode('sender_email')
                        ->defaultValue(null)
                        ->end()
                 
                    ->scalarNode('sender_name')
                        ->defaultValue(null)
                        ->end()
                                    
                ->end();

        return $treeBuilder;
    }
}
