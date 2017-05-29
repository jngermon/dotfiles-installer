<?php

namespace DotfilesInstaller\Component\Instruction;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dotfiles');

        $rootNode
            ->children()
                ->arrayNode('remotes')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')
                                ->isRequired()
                            ->end()
                            ->scalarNode('url')
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('links')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('source')
                                ->isRequired()
                                ->example('.zshrc')
                            ->end()
                            ->scalarNode('target')
                                ->isRequired()
                                ->example('~/.zshrc')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('imports')
                    ->example('[other_dir/dotfiles-custom.yml]')
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
