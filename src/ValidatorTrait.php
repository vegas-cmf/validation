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
namespace Vegas\Validation;

trait ValidatorTrait
{
    protected $validator;
    protected $attribute;
    
    public function validate($validator, $attribute)
    {
        $this->validator = $validator;
        $this->attribute = $attribute;

        $value = $this->resolveValue();
        
        if (is_array($value)) {
            return $this->validateArray($value);
        }
        
        return $this->validateSingle($value);
    }
    
    protected function validateArray(array $values)
    {
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

    private function resolveValue()
    {
        $name = $this->resolveName();

        if (is_array($name)) {
            $value = $this->validator->getValue($name[1]);
            return $value[$name[2]];
        }

        return $this->validator->getValue($name);
    }

    private function resolveName()
    {
        $matches = array();

        if (preg_match('/^([a-zA-Z0-9\-\_]+)\[([a-zA-Z0-9\-\_]*)\](\[([a-zA-Z0-9\-\_]*)\])?$/', $this->attribute, $matches)) {
            return $matches;
        }

        return $this->attribute;
    }

    abstract protected function validateSingle($value);
}