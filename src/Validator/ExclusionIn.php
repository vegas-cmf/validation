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

class ExclusionIn extends Validator\ExclusionIn
{
    use \Vegas\Validation\ValidatorTrait;

    protected function validateSingle($value)
    {
        if (in_array($value, $this->getOption('domain'))) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'ExclusionIn'));
            return false;
        }

        return true;
    }

    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'Field value can not be one of the: '.implode(', ', $this->getOption('domain')).'.';
        }

        return $message;
    }

}
