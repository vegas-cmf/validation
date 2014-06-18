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

class StringLength extends Validator\StringLength
{
    use \Vegas\Validation\ValidatorTrait;

    protected function validateSingle($value)
    {
        $valid = true;

        if (mb_strlen($value) > $this->getOption('max')) {
            $this->validator->appendMessage(new Message($this->getMessageMaximum(), $this->attribute, 'StringLength'));
            $valid = false;
        }

        if (mb_strlen($value) < $this->getOption('min')) {
            $this->validator->appendMessage(new Message($this->getMessageMinimum(), $this->attribute, 'StringLength'));
            $valid = false;
        }

        return $valid;
    }

    private function getMessageMinimum()
    {
        $message = $this->getOption('messageMinimum');
        if (!$message) {
            $message = 'Minimum length of string is '.$this->getOption('min');
        }

        return $message;
    }

    private function getMessageMaximum()
    {
        $message = $this->getOption('messageMaximum');
        if (!$message) {
            $message = 'Maximum length of string is '.$this->getOption('max');
        }

        return $message;
    }
}
