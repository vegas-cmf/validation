<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <aostrycharz@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Validation\Validator;
	
use Phalcon\Validation\Validator;
use Phalcon\Validation\Message;
use Phalcon\Validation\ValidatorInterface;
use Vegas\Validation\Validator\Unique\Adapter\Mongo;
use Vegas\Validation\Validator\Unique\Exception\ModelNameNotSetException;

class Unique extends Validator implements ValidatorInterface
{
    use \Vegas\Validation\ValidatorTrait;
    
    protected function validateSingle($value)
    {
        $record = $this->getRecord($value);

        if (!empty($record)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Unique'));
            return false;
        }

        return true;
    }

    private function getRecord($value)
    {
        $adapter = $this->getOption('adapter');
        $modelName = $this->getOption('modelName');
        $fieldName = $this->getOption('fieldName');

        if (!$modelName) {
            throw new ModelNameNotSetException();
        }

        if (!$fieldName) {
            $fieldName = $this->attribute;
        }

        if (!$adapter) {
            $adapter = new Mongo();
        }

        $adapter->setModelName($modelName);

        return $adapter->retrieveOneBy($fieldName, $value);
    }

    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'Value already exists in database';
        }
        
        return $message;
    }
}
