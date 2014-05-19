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

class Phone extends Validator
{
    use \Vegas\Validation\ValidatorTrait;
    
    protected function validateSingle($value)
    {
        if ($value && !preg_match('/(([0-9]{4})|(\+[0-9]{2}))?[ \.]?[0-9]{6,10}/',$value)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Phone'));
            return false;
        }
        
        return true;   
    }
    
    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'The phone number should be in the +XX XXXXXXXXX or XXXX XXXXXXXXX format.';
        }
        
        return $message;
    }
}
