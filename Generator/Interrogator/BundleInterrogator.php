<?php
/**
 * User: boshurik
 * Date: 21.04.16
 * Time: 19:19
 */

namespace BoShurik\AdminBundle\Generator\Interrogator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class BundleInterrogator implements InterrogatorInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @inheritDoc
     */
    public function interrogate(Metadata $metadata, QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output)
    {
        $class = $metadata->getClass()->getName();
        foreach ($this->kernel->getBundles() as $bundle) {
            if (strpos($class, $bundle->getNamespace()) === 0) {
                $metadata->setBundle($bundle);
            }
        }

        if (!$metadata->hasBundle()) {
            throw new \LogicException(sprintf('Can\'t find bundle for "%s" object', $class));
        }
    }
}