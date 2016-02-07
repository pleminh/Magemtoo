<?php
namespace Magemtoo\Command\Traits;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class ProcessEntityController
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Command
 */
trait ProcessEntityControllerTraits
{
    /**
     * @param $helperSet
     * @param $output
     * @param $input
     */
    public function initProcessController($helperSet, &$output, &$input)
    {
        $dialog = $helperSet->get('dialog');
        $helper = $helperSet->get('question');

        // Which Controller ?
        /****************************
         * QUESTION
         ***************************/
        $choice = $this->buildChoicesQuestion($helper, $input, $output,
            'Which type of controller would you create?',
            ['Backend', 'Frontend']
        );
    }



}