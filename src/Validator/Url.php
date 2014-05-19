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

class Url extends Validator
{
    use \Vegas\Validation\ValidatorTrait;
    
    protected function validateSingle($value) {
        if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Url'));
            return false;
        }
        
        return true;   
    }

    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'The URL is not valid';
        }
        
        return $message;
    }
}
