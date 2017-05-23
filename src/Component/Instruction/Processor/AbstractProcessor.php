<?php

namespace DotfilesInstaller\Component\Instruction\Processor;

use Mmc\Processor\Component\AbstractProcessor as BaseAbstractProcessor;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractProcessor extends BaseAbstractProcessor
{
    abstract protected function getSupportedActions();
    abstract protected function getSupportedInstructions();

    protected $repositoriesPath;

    protected $pathConverter;

    public function __construct(
        $repositoriesPath,
        $pathConverter
    ) {
        $this->repositoriesPath = $repositoriesPath;
        $this->pathConverter = $pathConverter;
    }

    public function supports($request)
    {
        try {
            $request = $this->createOptionsResolver()->resolve($request);

            return in_array($request['action'], $this->getSupportedActions());
        } catch (ExceptionInterface $e) {
            return false;
        }

        return false;
    }

    protected function createOptionsResolver()
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            'action',
            'instruction'
        ]);

        $resolver->setAllowedTypes('action', ['string']);
        $resolver->setAllowedTypes('instruction', $this->getSupportedInstructions());

        return $resolver;
    }
}
