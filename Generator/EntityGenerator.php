<?php
namespace Magemtoo\Generator;

use Magemtoo\Model\Module;
use Magento\Framework\App\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class EntityGenerator
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 * @see
 *
 * @package Magemtoo\Generator
 */
class EntityGenerator extends Generator
{


    const MODULE_DIR_PATH = 'code';
    /**
     * @var Entity
     */
    private $entity;

    /**
     * ModuleGenerator constructor.
     * @param Module $module
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
        parent::__construct();
    }


    public function generate()
    {
        $dir = $this->entity->getTargetDirectory() . self::MODULE_DIR_PATH . '/' . trim(strtr($this->entity->getNamespace(), '\\', '/'), '/');

        $this->checkIfModuleAlreadyExists($dir, $this->entity->getName());

        $parameters = array(
            'module_name' => $this->entity->getMagentoModuleName(),
            'namespace' => $this->entity->getNamespace(),
            'TEST' => 'hhhh',
        );

    }

    /**
     * @param $dir
     * @param $moduleName
     * @return bool
     */
    protected function checkIfModuleAlreadyExists($dir, $moduleName)
    {
        $target = $dir .'/'. $moduleName;
        if (is_dir($target)) {
            throw new \RuntimeException(
                'The module name \'' . $moduleName . '\' is already exists.'
            );
        }
        return true;
    }
}