<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 17:59
 */

namespace BoShurik\AdminBundle\Generator;

use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class AdminGenerator
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem $filesystem
     */
    protected $filesystem;

    /**
     * @var string $skeletonDir
     */
    protected $skeletonDir;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     * @param string $skeletonDir
     */
    public function __construct(Filesystem $filesystem, $skeletonDir)
    {
        $this->filesystem  = $filesystem;
        $this->skeletonDir = $skeletonDir;
    }

    public function generate(BundleInterface $bundle, $entity, ClassMetadataInfo $metadata, $routePrefix)
    {
        echo 'TODO: generate';
    }
}
