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
namespace Vegas\Tests\Validation\Validator;

use Vegas\Validation\Validator\StringLength;

class StringLengthTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();

        $validator = new StringLength(array('min' => 3, 'max' => 5));
        $this->validation->add('value', $validator);
    }

    public function testSingleInput()
    {
        $badValue = array('value' => 'foo bar');
        $messages = $this->validation->validate($badValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('value' => 'foo');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badValues = array('value' => array('fo','foobar baz'));
        $messages = $this->validation->validate($badValues);

        $this->assertEquals(1, count($messages));

        $mixedValues = array('value' => array('fo','fooba'));
        $messages = $this->validation->validate($mixedValues);

        $this->assertEquals(1, count($messages));

        $correctValues = array('value' => array('foo', 3.142, 'foo b'));
        $messages = $this->validation->validate($correctValues);

        $this->assertEquals(0, count($messages));
    }
}
