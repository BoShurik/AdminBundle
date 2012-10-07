<?php
/**
 * Created by JetBrains PhpStorm.
 * User: BoShurik
 * Date: 07.10.12
 * Time: 18:17
 */

namespace BoShurik\AdminBundle\Generator;

abstract class Generator
{
    protected function render($skeletonDir, $template, $parameters)
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem($skeletonDir), array(
            'debug'            => true,
            'cache'            => false,
            'strict_variables' => true,
            'autoescape'       => false,
        ));

        return $twig->render($template, $parameters);
    }

    protected function renderFile($skeletonDir, $template, $target, $parameters)
    {
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }

        if (!is_file($target)) {
            return file_put_contents($target, $this->render($skeletonDir, $template, $parameters));
        }

        return 0;
    }
}
