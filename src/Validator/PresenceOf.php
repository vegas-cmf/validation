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

class PresenceOf extends Validator\PresenceOf implements ValidatorInterface
{
    use \Vegas\Validation\ValidatorTrait;
    
    protected function validateSingle($value)
    {
        if ($value === null || $value === '') {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'PresenceOf'));
            return false;
        }

        return true;
    }

    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'Field is required.';
        }

        return $message;
    }
}
