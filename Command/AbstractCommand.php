<?php
namespace Magemtoo\Command;

use Symfony\Component\Console\Command\Command;
use \Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Class AbstractCommand
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Command
 */
class AbstractCommand extends Command
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;
    /**
     * @var
     */
    protected $output;
    /**
     * @var
     */
    protected $om;
    /**
     * @var
     */
    protected $twigEngine;

    public function __construct(ObjectManagerInterface $manager)
    {
        $this->objectManager = $manager;
        parent::__construct();
        $this->twigEngine  = $this->objectManager
            ->get('Magemtoo\Twig\Framework\TemplateEngine\Twig');
    }

    /**
     * @return ObjectManagerInterface
     */
    protected function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * @param $helper
     * @param $input
     * @param $output
     * @param $question
     * @param array $options
     * @param null $defaultValue
     * @param bool $multiSelect
     * @return mixed
     */
    protected function buildChoicesQuestion(
        $helper,
        &$input,
        &$output,
        $question,
        array $options,
        $defaultValue = null,
        $multiSelect = false
    )
    {
        $choiceQuestion = new ChoiceQuestion(
            $question,
            $options,
            $defaultValue
        );
        $choiceQuestion->setMultiselect($multiSelect);

        return $helper->ask($input, $output, $choiceQuestion);
    }

    /**
     * @param $arrayOptions
     * @param $helper
     * @param $input
     * @param $output
     */
    protected function helperTrueOrFalse(&$arrayOptions, $helper, &$input, &$output)
    {
        foreach ($arrayOptions as $key => $val) {
            $res = $this->buildChoicesQuestion($helper, $input, $output,
                $key,
                ['true', 'false']
            );
            if ($key === 'primary') {
                // @TODO Check if column is already set to primary
                //throw new \RuntimeException('Another column has already set to primary.');
            }
            $arrayOptions[$key] = $res;
        }
    }

}
