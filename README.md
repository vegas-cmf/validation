Vegas CMF Validation lib
======================

# List of contents

* Vegas\Validation\ValidatorTrait
* Vegas\Validation\Validator\Email
* Vegas\Validation\Validator\Ip
* Vegas\Validation\Validator\Phone
* Vegas\Validation\Validator\SameAs
* Vegas\Validation\Validator\SizeOf
* Vegas\Validation\Validator\Unique
* Vegas\Validation\Validator\Url

# Vegas\Validation\ValidatorTrait#

### Description ###
Use this trait to change validator behavior. Class will validate not only single values but also each of arrayed values.

### Usage ###
```
#!php
<?php
use Phalcon\Validation\Validator,
    Phalcon\Validation\Message;

class Email extends Validator
{
    use \Vegas\Validation\ValidatorTrait;

    protected function validateSingle($value)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->validator->appendMessage(new Message($this->getMessage(), $this->attribute, 'Email'));
            return false;
        }

        return true;
    }

    private function getMessage()
    {
        $message = $this->getOption('message');
        if (!$message) {
            $message = 'One of the emails is not valid.';
        }

        return $message;
    }
}
```

All validators below use *Vegas\Validation\ValidatorTrait* to validate both single and array values.

# Vegas\Validation\Validator\Email #

E-mail validation based on PHP *filter_var* function.

# Vegas\Validation\Validator\Ip #

Simple IP validation for both IPv4 and IPv6.

# Vegas\Validation\Validator\Phone #

Phone validation. Correct number formats are +XX XXXXXXXXX or XXXX XXXXXXXXX.

# Vegas\Validation\Validator\SizeOf #

### Description ###

You can use it with [Cloneable Form Element](New Form Elements), [MutliSelect Form Element](New Form Elements) or any other form element that have countable fields. **SizeOf Validator** will count non-empty fields and compare them to numbers given by *min* and *max* options.

### Usage ###

```
#!php
<?php
$arrayValuedElement->addValidator(new SizeOf(array('min' => 2, 'max' => 6)));
```

# Vegas\Validation\Validator\Url #

URL validation based on PHP *filter_var* function.