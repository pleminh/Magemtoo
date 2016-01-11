<?php

namespace Magemtoo\Generator;
use Magemtoo\Twig\Framework\TemplateEngine\Twig;

/**
 * Class Generator
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Generator
 */
class Generator extends Twig
{

    /**
     * @param $template
     * @param $target
     * @param $parameters
     * @return int
     */
    protected function renderFile($template, $target, $parameters)
    {
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0777, true);
        }

        return file_put_contents($target, $this->render($template, $parameters));
    }
}