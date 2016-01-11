<?php
namespace Magemtoo\Twig\Framework\TemplateEngine;

use Magemtoo\Repository\CommonRepository;
use Magento\Framework\App\Filesystem\DirectoryList;


/**
 * Class Twig
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Twig\Framework\TemplateEngine
 */
class Twig extends CommonRepository
{
    const TWIG_CACHE_DIR = 'twig';
    const MODULE_NAME = 'Pleminh_Magemtoo';
    const TEMPLATE_PATH = '/Resources/skeleton';

    /**
     * @var \Twig_Environment
     */
    private $twig = null;

    /**
     * @var DirectoryList
     */
    protected $_directoryList;

    /**
     * Twig constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->twig = $this->initTwig();
    }


    /**
     * Inits Twig
     * @return \Twig_Environment
     */
    public function initTwig()
    {
        return new \Twig_Environment($this->getLoader(), array(
            'debug' => true,
            'cache' => false,
            'strict_variables' => true,
            'autoescape' => false,
        ));
    }

    /**
     * @return \Twig_Loader_Filesystem
     */
    private function getLoader()
    {
        $loader = new \Twig_Loader_Filesystem(
            $this->getModuleDir(self::MODULE_NAME) . self::TEMPLATE_PATH
        );
        return $loader;
    }

    /**
     * @param $name
     * @param array $context
     * @return string
     */
    public function render($name, array $context = array())
    {
        return $this->twig->render($name, $context);
    }

    /**
     * @return string
     */
    public function test()
    {
        return 'Hello World!';
    }
}