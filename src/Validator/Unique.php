<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <arkadiusz.ostrycharz@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Validation\Validator;
	
use Phalcon\Validation\Validator,
    Phalcon\Validation\Message;

class Unique extends Validator
{
    use \Vegas\Validation\ValidatorTrait;
    
    protected function validateSingle($value)
    {
        if (!$this->isSetOption('modelName')) {
            throw new ModelNameNotSetException();
        }

        if (!$this->isSetOption('methodName')) {
            $this->setOption('methodName', 'findById');
        }

        $modelName = $this->getOption('modelName');
        $methodName = $this->getOption('methodName');

        $record = $modelName::$methodName($value);

        if (!empty($record)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Unique'));
            return false;
        }

        return true;
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
