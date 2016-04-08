<?php
/**
 * User: boshurik
 * Date: 30.04.16
 * Time: 23:12
 */

namespace BoShurik\AdminBundle\Generator\Generator;

use BoShurik\AdminBundle\Generator\Metadata;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Yaml\Yaml;

class TranslationGenerator extends AbstractGenerator
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(Renderer $renderer, TranslatorInterface $translator)
    {
        parent::__construct($renderer);

        $this->translator = $translator;
    }

    /**
     * @inheritDoc
     */
    public function generate(Metadata $metadata, OutputInterface $output)
    {
        if (method_exists($this->translator, 'getFallbackLocales')) {
            $locales = $this->translator->getFallbackLocales();
        } else {
            $locales = array($this->translator->getLocale());
        }

        $translations = $this->getTranslations($metadata);

        foreach ($locales as $locale) {
            $path = sprintf('%s/Resources/translations/BoShurikAdminBundle.%s.yml',
                $metadata->getBundle()->getPath(),
                $locale
            );

            $this->generateLocale($translations, $path);
        }
    }

    /**
     * @param array $translations
     * @param string $path
     */
    private function generateLocale($translations, $path)
    {
        $content = file_exists($path) ? Yaml::parse(file_get_contents($path)) : array();
        $content = array_merge($content, $translations);

        $this->renderer->writeFile(Yaml::dump($content, 6), $path);
    }

    /**
     * @param Metadata $metadata
     * @return array
     */
    private function getTranslations(Metadata $metadata)
    {
        $translations = array();
        foreach ($metadata->getClass()->getFieldNames() as $field) {
            $translations[$field] = $this->humanize($field);
        }
        foreach ($metadata->getClass()->getAssociationNames() as $field) {
            $translations[$field] = $this->humanize($field);
        }
        $translations['_interface'] = array_fill_keys(array(
            'name',
            'menu',
            'list',
            'create',
            'show',
            'edit',
            'delete',
        ), $this->humanize($metadata->getClassName()));

        $result = array(
            'controller' => array(
                'admin' => array(),
            ),
        );

        $path = &$result['controller']['admin'];
        foreach ($metadata->getClassParts() as $key => $part) {
            $path = &$path[mb_strtolower($part)];
        }

        $path = $translations;

        return $result;
    }

    /**
     * @param string $text
     * @return mixed
     */
    private function humanize($text)
    {
        return ucfirst(trim(strtolower(preg_replace(array('/([A-Z])/', '/[_\s]+/'), array('_$1', ' '), $text))));
    }
}