<?php
/**
 * This file is part of Vegas package
 * SizeOf validator is usable only by data sets (arrays). It counts non-empty
 * values and compare to min/max options set by user.
 * 
 * Example:
 * <code>
 * $test->addValidator(new SizeOf(array('min' => 2, 'max' => 3))); 
 * </code>
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

class SizeOf extends Validator implements ValidatorInterface
{
    use \Vegas\Validation\ValidatorTrait;
    
    public function validate(\Phalcon\Validation $validator, $attribute)
    {
        $this->validator = $validator;
        $this->attribute = $attribute;
        
        $value = $validator->getValue($attribute);
        
        if (empty($value)) {
            $value = array();
        }
        
        if (is_array($value)) {
            return $this->validateAll($value);
        }
        
        $this->validator->appendMessage(new Message('Validator suitable only for data sets.', $this->attribute, 'SizeOf'));
        return false;
    }
    
    protected function validateAll(array $values)
    {
        $present = $this->validateArray($values);

        $min = $this->getOption('min');

        if ($min && $present < $min) {
            $this->validator->appendMessage(new Message($this->getMessageMinimum(), $this->attribute, 'SizeOf'));
            return false;
        }

        $max = $this->getOption('max');

        if ($max && $present > $max) {
            $this->validator->appendMessage(new Message($this->getMessageMaximum(), $this->attribute, 'SizeOf'));
            return false;
        }

        return true;
    }
    
    protected function validateArray(array $values) {
        $present = 0;
        
        foreach ($values As $value) {
            if (is_array($value)) {
                $present += (bool)$this->validateArray($value);
            } else {
                $present += $this->validateSingle($value);
            }
        }

        return $present;
    }
    
    protected function validateSingle($value)
    {
        if ($value === '' || $value === null) {
            return 0;
        }
        
        return 1;   
    }
    
    private function getMessageMinimum()
    {
        $message = $this->getOption('messageMinimum');
        if (!$message) {
            $message = 'Minimum number of required fields is '.$this->getOption('min');
        }
        
        return $message;
    }
    
    private function getMessageMaximum()
    {
        $message = $this->getOption('messageMaximum');
        if (!$message) {
            $message = 'Maximum number of required fields is '.$this->getOption('max');
        }
        
        return $message;
    }
}
