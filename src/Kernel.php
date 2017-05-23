<?php

namespace DotfilesInstaller;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Kernel
{
    const VERSION = '0.1';

    protected $environment;

    protected $debug;

    protected $container;

    public function __construct(
        $environment,
        $debug
    ) {
        $this->environment = $environment;
        $this->debug = $debug;

        $this->container = new ContainerBuilder();
        $loader = new XmlFileLoader($this->container, new FileLocator(__DIR__ . '/../app/config'));
        $loader->load('services.xml');

        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__ . '/../app/config'));
        $loader->load('parameters.yml');

        $this->container->setParameter('kernel.environment', $this->environment);
        $this->container->setParameter('kernel.debug', $this->debug);
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
