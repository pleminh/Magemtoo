<?php
namespace Magemtoo\Command;


use Magemtoo\Generator\ModuleGenerator;
use Magemtoo\Model\Module;
use Magemtoo\Twig\Framework\TemplateEngine\Twig;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;

/**
 * Class GenerateModule
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Command
 */
class GenerateModule extends Command
{

    protected $output;
    protected $om;
    protected $twigEngine;
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

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

    protected function configure()
    {
        $this->setName('magemtoo:generate:module');
        $this->setDescription('Generates a module base skeleton');
        $this->setDefinition(
            [
                new InputOption('vendor-name', null, InputOption::VALUE_REQUIRED, 'The vendor name - used for namespace - eg : Magemtoo'),
                new InputOption('module-name', null, InputOption::VALUE_REQUIRED, 'The module name - word that describes what the module does. eg : Swifter'),
//                new InputOption('namespace', null, InputOption::VALUE_REQUIRED, 'The namespace of the module to create'),
            ]
        );
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelperSet()->get('dialog');

        $vendorName = $input->getOption('vendor-name');
        $moduleName = $input->getOption('module-name');

        $this->output = $output;

        // TODO
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

        $dialog = $this->getHelperSet()->get('dialog');

        // Get ModuleName
        $output->writeln(array(
            '',
            'First, you need to give the vendor\'s and the module\'s name where the command will',
            'be generated',
            '(e.g. for Vendor\'s name <comment>MyVendor</comment>)',
            '(e.g. for Module\'s name <comment>MyModule</comment>)',
            '',
        ));

        $vendorName = $dialog->askAndValidate(
            $output,
            'Please enter the vendor\'s name: ',
            function ($answer) {
                if (empty(trim($answer))) {
                    throw new \RuntimeException(
                        'The name of the vendor should not be empty. Please enter a name.'
                    );
                }
                return $answer;
            },
            false,
            null
        );

        $moduleName = $dialog->askAndValidate(
            $output,
            'Please enter the name of the module: ',
            function ($answer) {
                if (empty(trim($answer))) {
                    throw new \RuntimeException(
                        'The name of the module should not be empty. Please enter a name.'
                    );
                }
                return $answer;
            },
            false,
            null
        );

        $input->setOption('vendor-name', $vendorName);
        $input->setOption('module-name', $moduleName);

        // Summary and confirmation
        $output->writeln(array(
            '',
            $this->getHelper('formatter')->formatBlock('Summary before generation', 'bg=blue;fg-white', true),
            '',
            sprintf('You are going to generate a skeleton base module with the name <info>%s</info>.', $moduleName),
        ));

        $question = 'Do you confirm generation of the module <info>'.$moduleName.'</info> [<comment>yes</comment>]?';
        if (!$dialog->askConfirmation($output, $question, true)) {
            $output->writeln(array(
                '<error>Command aborted!</error>'
            ));
            return 1;
        }

        $this->createGenerator($vendorName, $moduleName, $this->twigEngine->getAppDir())->generateModule();

    }

    /**
     * @param $string
     */
    protected function output($string)
    {
        $this->output->writeln($string);
    }

    /**
     * @param $namespace
     * @param $name
     * @param $targetDirectory
     * @return ModuleGenerator
     */
    protected function createGenerator($namespace, $name, $targetDirectory)
    {
        $module = new Module($namespace, $name, $targetDirectory);
        return new ModuleGenerator($module);
    }


}
