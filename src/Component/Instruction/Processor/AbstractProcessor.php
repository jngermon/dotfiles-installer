<?php

namespace DotfilesInstaller\Component\Instruction\Processor;

use Mmc\Processor\Component\AbstractProcessor as BaseAbstractProcessor;
use Symfony\Component\OptionsResolver\Exception\ExceptionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractProcessor extends BaseAbstractProcessor
{
    abstract protected function getSupportedActions();
    abstract protected function getSupportedInstructions();

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
