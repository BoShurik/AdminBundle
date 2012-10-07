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

    protected function renderFile($skeletonDir, $template, $target, $parameters, $append = false)
    {
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }

        $parameters['append'] = false;

        if (!file_exists($target)) {
            return file_put_contents($target, $this->render($skeletonDir, $template, $parameters));
        }

        if ($append) {
            if (!file_exists($target)) {
                return file_put_contents($target, $this->render($skeletonDir, $template, $parameters));
            } else {
                $parameters['append'] = true;

                $content = file_get_contents($target);

                $contentToAppend = $this->render($skeletonDir, $template, $parameters);
                if (strpos($content, $contentToAppend) === false) {
                    $content .= $contentToAppend;

                    return file_put_contents($target, $content);
                }
            }
        }

        return 0;
    }
}
