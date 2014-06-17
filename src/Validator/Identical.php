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

class Identical extends Validator\Identical
{
    use \Vegas\Validation\ValidatorTrait;

    protected function validateSingle($value)
    {
        if ($value !== $this->getOption('value')) {
            $this->validator->appendMessage(new Message($this->getOption('message'), $this->attribute, 'Identical'));
            return false;
        }

        return true;
    }
}
