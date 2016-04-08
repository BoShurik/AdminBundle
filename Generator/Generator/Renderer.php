<?php
/**
 * User: boshurik
 * Date: 22.04.16
 * Time: 12:59
 */

namespace BoShurik\AdminBundle\Generator\Generator;

class Renderer
{
    /**
     * @var array
     */
    private $skeletonDirs;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct($skeletonDirs)
    {
        $this->skeletonDirs = $skeletonDirs;
        $this->twig = null;
    }

    /**
     * @param $template
     * @param $parameters
     * @return string
     */
    public function render($template, $parameters)
    {
        $twig = $this->getTwigEnvironment();

        return $twig->render($template, $parameters);
    }

    /**
     * @param $template
     * @param $target
     * @param $parameters
     * @return mixed
     */
    public function renderFile($template, $target, $parameters)
    {
        return $this->writeFile($this->render($template, $parameters), $target);
    }

    /**
     * @param string $content
     * @param string $target
     * @return mixed
     */
    public function writeFile($content, $target)
    {
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }

        return file_put_contents($target, $content);
    }

    /**
     * Get the twig environment that will render skeletons.
     *
     * @return \Twig_Environment
     */
    private function getTwigEnvironment()
    {
        if (!$this->twig) {
            $this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem($this->skeletonDirs), array(
                'debug' => true,
                'cache' => false,
                'strict_variables' => true,
                'autoescape' => false,
            ));
        }

        return $this->twig;
    }
}