<?php
namespace Magemtoo\Command\Traits;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class ProcessModuleSkeletonTraits
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Command
 */
trait ProcessModuleSkeletonTraits
{

    /**
     * @param $helperSet
     * @param $output
     * @param $input
     */
    public function initProcessModuleSkeleton($helperSet, &$output, &$input)
    {
        $dialog = $helperSet->get('dialog');
        $helper = $helperSet->get('question');

    }





}