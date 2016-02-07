<?php
namespace Magemtoo\Model;

/**
 * Class Entity
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Model
 */
class Entity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}