<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniołek <mateusz.aniolek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Validation\Validator;

use Phalcon\Validation\Validator;
use Phalcon\Validation\Message;
use \Vegas\Validation\Validator\Date\Exception\FormatNotSetException;

class Date extends Validator
{
    use \Vegas\Validation\ValidatorTrait;

    protected function validateSingle($value)
    {
        if ($value && !$this->validateDateTime($value)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Date'));
            return false;
        }
        
        return true;
    }

    private function validateDateTime($value)
    {
        if(!$this->isSetOption('format')) {
            throw new FormatNotSetException();
        }
        $date = \DateTime::createFromFormat($this->getOption('format'), $value);
        if(!$date) {
            return false;
        } else {
            return true;
        }

    }
    
    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'Date is not valid.';
        }
        
        return $message;
    }
}
