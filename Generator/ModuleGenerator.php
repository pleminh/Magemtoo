<?php
namespace Magemtoo\Generator;

use Magemtoo\Model\Module;
use Magento\Framework\App\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class ModuleGenerator
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 * @see http://devdocs.magento.com/guides/v2.0/extension-dev-guide/module-file-structure.html
 *
 * @package Magemtoo\Generator
 */
class ModuleGenerator extends Generator
{

    const MODULE_DIR_PATH = 'code';
    /**
     * @var Module
     */
    private $module;

    /**
     * ModuleGenerator constructor.
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
        parent::__construct();
    }


    public function generateModule()
    {
        $dir = $this->module->getTargetDirectory() . self::MODULE_DIR_PATH . '/' . trim(strtr($this->module->getNamespace(), '\\', '/'), '/');

        $this->checkIfModuleAlreadyExists($dir, $this->module->getName());

        $parameters = array(
            'module_name' => $this->module->getMagentoModuleName(),
            'namespace' => $this->module->getNamespace(),
            'TEST' => 'hhhh',
        );



        // Generate 'module.xml' files
        $this->renderFile('module/etc/module.xml.twig', $dir.'/etc/module.xml', $parameters);

        // Generate 'registration.php' files
        $this->renderFile('module/registration.php.twig', $dir.'/registration.php', $parameters);

        // Generate 'etc/config.xml' files
        $this->renderFile('module/etc/config.xml.twig', $dir.'/etc/config.xml', $parameters);

        // Generate 'etc/frontend/routes.xml' files
        $this->renderFile('module/etc/frontend/routes.xml.twig', $dir.'/etc/frontend/routes.xml', $parameters);

        // Generate Controller Index files
        $this->renderFile('module/Controller/Index/index.php.twig', $dir.'/Controller/Index/index.php', $parameters);

        // Generate Block files
        $this->renderFile('module/Block/MyBlock.php.twig', $dir.'/Block/MyBlock.php', $parameters);

        // Generate View frontend layout
        $this->renderFile('module/View/frontend/layout/base_index.xml.twig', $dir.'/View/frontend/layout/'.strtolower($this->module->getMagentoModuleName()).'_index_index.xml', $parameters);

        // Generate View frontend templates
        $this->renderFile('module/View/frontend/templates/index.phtml.twig', $dir.'/View/frontend/templates/index.phtml', $parameters);

    }


}