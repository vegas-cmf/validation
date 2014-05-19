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
namespace Vegas\Validation;

trait ValidatorTrait
{
    protected $validator;
    protected $attribute;
    
    public function validate($validator, $attribute)
    {
        $this->validator = $validator;
        $this->attribute = $attribute;
        
        $value = $validator->getValue($attribute);
        
        if (is_array($value)) {
            return $this->validateArray($value);
        }
        
        return $this->validateSingle($value);
    }
    
    protected function validateArray(array $values) {
        $valid = true;
        
        foreach ($values As $value) {
            if (is_array($value)) {
                $valid = $valid && $this->validateArray($value);
            } else {
                $valid = $valid && $this->validateSingle($value);
            }
        }
        
        return $valid;
    }
    
    abstract protected function validateSingle($value);
}