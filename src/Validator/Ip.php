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

class Ip extends Validator
{
    use \Vegas\Validation\ValidatorTrait;
    
    protected function validateSingle($value)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Ip'));
            return false;
        }
        
        return true;   
    }
    
    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'The IP is not valid';
        }
        
        return $message;
    }
}
