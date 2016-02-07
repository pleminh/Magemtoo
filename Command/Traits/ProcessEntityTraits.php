<?php
namespace Magemtoo\Command\Traits;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Class ProcessEntityTraits
 *
 * @author Pascal LE MINH <pascal.leminh@gmail.com>
 *
 * @package Magemtoo\Command
 */
trait ProcessEntityTraits
{
    static $TYPE_BOOLEAN  = 'bool';
    static $TYPE_SMALLINT = 'smallint';
    static $TYPE_INTEGER  = 'int';
    static $TYPE_BIGINT   = 'bigint';
    static $TYPE_FLOAT    = 'float';
    static $TYPE_DECIMAL  = 'decimal';
    static $TYPE_NUMERIC  = 'decimal';
    static $TYPE_DATE     = 'date';
    static $TYPE_TIMESTAMP= 'timestamp';
    static $TYPE_DATETIME = 'datetime';
    static $TYPE_TEXT     = 'text';
    static $TYPE_BLOB     = 'blob';
    static $TYPE_VARBINARY= 'blob';

    /**
     * @param $helperSet
     * @param $output
     * @param $input
     */
    public function initProcessEntity($helperSet, &$output, &$input)
    {
        $dialog = $helperSet->get('dialog');
        $helper = $helperSet->get('question');

        $entityName = $dialog->askAndValidate(
            $output,
            'Please enter the name of the entity: ',
            function ($answer) {
                if (empty(trim($answer))) {
                    throw new \RuntimeException(
                        'The name of the entity should not be empty. Please enter a name.'
                    );
                }
                return $answer;
            },
            false,
            null
        );
        $input->setOption('entity-name', $entityName);

        /******************************************************
         *
         * Create Table of the entity with columns
         *  to generate Setup/InstallSchema.php
         *
         ******************************************************/
        $output->writeln(array(
            '',
            'Entity name will be create. you need to give some data type for each column where the command will',
            'be generated',
            '(e.g. id <comment>integer</comment>)',
            '(e.g. title <comment>varchar</comment>)',
            '',
        ));

        $columnsEntity = [];

        processCreateColumns: $columnName = $dialog->askAndValidate(
            $output,
            'Please enter the name of the column: ',
            function ($answer) use ($columnsEntity) {
                if (empty(trim($answer))) {
                    throw new \RuntimeException(
                        'The name of the column should not be empty. Please enter a name.'
                    );
                }
                // Check if column name is already add
                if (in_array($answer, $columnsEntity)) {
                    throw new \RuntimeException(
                        'The name of the column is already exists. Please enter another name.'
                    );
                }
                return $answer;
            },
            false,
            null
        );

        $columnDescription = $dialog->askAndValidate(
            $output,
            'Please enter a description of the column (optional): <info><Press enter to empty></info> ',
            function ($answer) {
                return $answer;
            },
            false,
            null
        );
        $columnsEntity[$columnName]['description'] = $columnDescription;

        /****************************
         * QUESTION
         ***************************/
        $dataType = $this->getDataTypeChoice($helper, $input, $output);

        $columnsEntity[$columnName]['type'] = $dataType;


        switch ($dataType) {
            case 'TYPE_SMALLINT':
            case 'TYPE_INTEGER':
            case 'TYPE_BIGINT':
                $arrayOptions = [
                    'identity' => '',
                    'unsigned' => '',
                    'nullable' => '',
                    'primary'  => ''
                ];

                $this->helperTrueOrFalse($arrayOptions, $helper, $input, $output);
                $columnsEntity[$columnName]['options'] = $arrayOptions;
                break;

            case 'TYPE_BOOLEAN':
                break;

            case 'TYPE_FLOAT':
                $arrayOptions = [ 'unsigned' => '' ];

                $this->helperTrueOrFalse($arrayOptions, $helper, $input, $output);
                $columnsEntity[$columnName]['options'] = $arrayOptions;
                break;

            case 'TYPE_DECIMAL':
            case 'TYPE_NUMERIC':
                $arrayOptions = [
                    'precision' => '',
                    'scale' => '',
                    'unsigned' => '',
                ];

                $this->helperTrueOrFalse($arrayOptions, $helper, $input, $output);
                $columnsEntity[$columnName]['options'] = $arrayOptions;
                break;

            case 'TYPE_DATE':
            case 'TYPE_DATETIME':
            case 'TYPE_TIMESTAMP':
                break;

            case 'TYPE_TEXT':
            case 'TYPE_BLOB':
            case 'TYPE_VARBINARY':
                // @TODO
                //$length = $size;
                break;

            default:
                throw new \RuntimeException('Invalid column data type "' . $dataType . '"');
        }



        // Summary on process
        $output->writeln(array(
            '',
            '<comment>Summary on process</comment>',
            '',
        ));

        foreach ($columnsEntity as $column => $value) {
            $output->writeln('<info>'.$column . '</info> => ' . $value['type'] . ' (' . self::${$value['type']} . ')');
        }

        // Would you like create another colums ?
        /****************************
         * QUESTION
         ***************************/
        $choice = $this->buildChoicesQuestion($helper, $input, $output,
                'Would you like create another colums ?',
                ['no', 'yes']
            );

        if ('yes' === $choice) {
            // Goto process create columns
            goto processCreateColumns;
        }
    }

    /**
     * getDataTypeChoice
     *
     * @param $helper
     * @param $input
     * @param $output
     * @return mixed
     */
    protected function getDataTypeChoice($helper, &$input, &$output)
    {

        /****************************
         * QUESTION
         ***************************/
        return $this->buildChoicesQuestion($helper, $input, $output,
            'Choose a data type of the column?',
            [
                'TYPE_BOOLEAN',
                'TYPE_SMALLINT',
                'TYPE_INTEGER',
                'TYPE_BIGINT',
                'TYPE_FLOAT',
                'TYPE_DECIMAL',
                'TYPE_NUMERIC',
                'TYPE_NUMERIC',
                'TYPE_DATE',
                'TYPE_TIMESTAMP',
                'TYPE_DATETIME',
                'TYPE_TEXT',
                'TYPE_BLOB',
                'TYPE_VARBINARY'
            ]
        );
    }



}