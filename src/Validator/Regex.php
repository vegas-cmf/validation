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

use Phalcon\Validation\Validator;
use Phalcon\Validation\Message;

class Regex extends Validator\Regex
{
    use \Vegas\Validation\ValidatorTrait;

    protected function validateSingle($value)
    {
        if (!preg_match($this->getOption('pattern'), $value)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Regex'));
            return false;
        }

        return true;
    }

    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'Field value should match '.$this->getOption('pattern').'.';
        }

        return $message;
    }
}
