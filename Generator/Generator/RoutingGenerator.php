<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 17:46
 */

namespace BoShurik\AdminBundle\Generator\Generator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Output\OutputInterface;

class RoutingGenerator extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    public function generate(Metadata $metadata, OutputInterface $output)
    {
        $routingPath = sprintf('%s%s.yml',
            mb_strtolower($metadata->getClassPath()),
            mb_strtolower($metadata->getClassName())
        );
        $path = sprintf('%s/Resources/config/routing/admin/%s',
            $metadata->getBundle()->getPath(),
            $routingPath
        );

        $this->renderer->renderFile('Routing/routing.yml.twig', $path, array(
            'metadata' => $metadata,
        ));

        $this->updateAdminRouting($metadata, $routingPath);
        $this->updateRouting($metadata);
    }

    /**
     * @param Metadata $metadata
     * @param $routingPath
     */
    private function updateAdminRouting(Metadata $metadata, $routingPath)
    {
        $path = sprintf('%s/Resources/config/routing/admin/routing.yml',
            $metadata->getBundle()->getPath()
        );

        $key = sprintf('_admin_%s:', $metadata->getPrefix());

        $content = '';
        if (file_exists($path)) {
            $content = file_get_contents($path);

            if (false !== strpos($content, $key)) {
                return;
            }
        } elseif (!is_dir($dir = dirname($path))) {
            mkdir($dir, 0777, true);
        }

        $content .= $key . "\n";
        $content .= sprintf("    resource: \"@%s/Resources/config/routing/admin/%s\"\n", $metadata->getBundle()->getName(), $routingPath);
        $content .= sprintf("    prefix:   %s\n", $metadata->getRoutingPrefix());

        $this->renderer->writeFile($content, $path);
    }

    /**
     * @param Metadata $metadata
     */
    private function updateRouting(Metadata $metadata)
    {
        $path = sprintf('%s/Resources/config/routing.yml',
            $metadata->getBundle()->getPath()
        );

        $key = sprintf('_admin:');
        $content = '';
        if (file_exists($path)) {
            $content = file_get_contents($path);

            if (false !== strpos($content, $key)) {
                return;
            }
        } elseif (!is_dir($dir = dirname($path))) {
            mkdir($dir, 0777, true);
        }

        $content .= $key . "\n";
        $content .= sprintf("    resource: \"@%s/Resources/config/routing/admin/routing.yml\"\n", $metadata->getBundle()->getName());
        $content .= sprintf("    prefix:   /admin\n");

        $this->renderer->writeFile($content, $path);
    }
}