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
namespace Vegas\Validation\Validator\Unique\Adapter;

use Vegas\Validation\Validator\Unique\AdapterInterface;

class Mongo implements AdapterInterface
{
    protected $modelName;

    public function setModelName($name)
    {
        $this->modelName = $name;

        return $this;
    }

    public function retrieveOneBy($fieldName, $value)
    {
        $modelName = $this->modelName;

        return $modelName::findFirst(array(array(
            $fieldName => $value
        )));
    }
}
