<?php
namespace Magemtoo\Model;

/**
 * Class Module
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Model
 */
class Module
{
    /**
     * @var string
     */
    private $vendor;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $targetDirectory;


    /**
     * Module constructor.
     * @param $vendor
     * @param $name
     * @param $targetDirectory
     */
    public function __construct($vendor, $name, $targetDirectory)
    {
        $this->vendor = $vendor;
        $this->name = $name;
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->vendor. '\\' .$this->name;
    }

    /**
     * @return string
     */
    public function getVendorName()
    {
        return $this->vendor;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMagentoModuleName()
    {
        return $this->vendor . '_' . $this->name;
    }

    /**
     * Returns the directory where the module will be generated.
     *
     * @return string
     */
    public function getTargetDirectory()
    {
        return rtrim($this->targetDirectory, '/').'/';
    }

}