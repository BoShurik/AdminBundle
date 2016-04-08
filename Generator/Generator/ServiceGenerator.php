<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 20:04
 */

namespace BoShurik\AdminBundle\Generator\Generator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Yaml\Yaml;

class ServiceGenerator extends AbstractGenerator
{
    /**
     * @inheritDoc
     */
    public function generate(Metadata $metadata, OutputInterface $output)
    {
        $path = sprintf('%s/Resources/config/admin.yml',
            $metadata->getBundle()->getPath()
        );

        $content = file_exists($path) ? Yaml::parse(file_get_contents($path)) : array();

        if (!isset($content['parameters']) || !is_array($content['parameters'])) {
            $content['parameters'] = array();
        }
        if (!isset($content['services']) || !is_array($content['services'])) {
            $content['services'] = array();
        }

        $serviceId = sprintf('%s.admin.%s',
            Container::underscore(str_replace('Bundle', '', $metadata->getBundle()->getName())),
            $metadata->getPrefix('_')
        );
        $serviceClassParameter = sprintf('%s.class', $serviceId);

        if (!isset($content['parameters'][$serviceClassParameter])) {
            $content['parameters'][$serviceClassParameter] = sprintf('%s\Controller\Admin%s\%sController',
                $metadata->getBundle()->getNamespace(),
                $metadata->getClassNamespace(),
                $metadata->getClassName()
            );
        }
        if (!isset($content['services'][$serviceId])) {
            $content['services'][$serviceId] = array(
                'class' => sprintf('%%%s%%', $serviceClassParameter),
                'calls' => array(
                    array(
                        'setContainer',
                        array(
                            '@service_container',
                        ),
                    ),
                ),
                'tags' => array(
                    array(
                        'name'  => 'bo_shurik_admin.controller',
                        'group' => 'default',
                    ),
                ),
            );
        }

        $this->renderer->writeFile(Yaml::dump($content, 4), $path);
    }
}