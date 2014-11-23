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
use Vegas\Validation\Validator\SameAs\Exception\MatchNotSetException;

class SameAs extends Validator
{
    use \Vegas\Validation\ValidatorTrait;

    protected function validateSingle($value)
    {
        if (!$this->isSetOption('match')) {
            throw new MatchNotSetException();
        }

        if ($value !== $this->validator->getValue($this->getOption('match'))) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'SameAs'));
            return false;
        }
        
        return true;   
    }
    
    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'Value don not match '.$this->getOption('match');
        }
        
        return $message;
    }
}
