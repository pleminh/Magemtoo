<?php

namespace Magemtoo\Repository;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class CommonRepository
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Repository
 */
class CommonRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * CommonRepository constructor.
     */
    public function __construct()
    {
        $this->objectManager = ObjectManager::getInstance();
    }

    /**
     * Get Module Directory
     * @param $moduleName
     * @param string $type
     * @return \Magento\Framework\Module\Dir\Reader
     */
    public function getModuleDir($moduleName, $type = '')
    {
        /** @var \Magento\Framework\Module\Dir\Reader $reader */
        $reader = $this->objectManager
            ->get('Magento\Framework\Module\Dir\Reader')
            ->getModuleDir($type, $moduleName);
        return $reader;
    }

    /**
     * Get File system caching directory (if file system caching is used)
     * @return \Magento\Framework\App\Filesystem\DirectoryList
     */
    public function getCacheDir()
    {
        /** @var \Magento\Framework\App\Filesystem\DirectoryList $directoryList */
        $directoryList = $this->objectManager
            ->get('Magento\Framework\App\Filesystem\DirectoryList')
            ->getPath(DirectoryList::CACHE);
        return $directoryList;
    }

    /**
     * Get Most of entire application Directory
     * @return \Magento\Framework\App\Filesystem\DirectoryList
     */
    public function getAppDir()
    {
        /** @var \Magento\Framework\App\Filesystem\DirectoryList $directoryList */
        $directoryList = $this->objectManager
            ->get('Magento\Framework\App\Filesystem\DirectoryList')
            ->getPath(DirectoryList::APP);
        return $directoryList;
    }
}