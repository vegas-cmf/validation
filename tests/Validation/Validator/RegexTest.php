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
namespace Vegas\Tests\Validation\Validator;

use Vegas\Validation\Validator\Regex;

class RegexTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();

        $validator = new Regex(array('pattern' => '/[abfor]{6}/'));
        $this->validation->add('value', $validator);
    }

    public function testSingleInput()
    {
        $badValue = array('value' => 'test');
        $messages = $this->validation->validate($badValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('value' => 'foobar');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badValues = array('value' => array('foobaz', 123));
        $messages = $this->validation->validate($badValues);

        $this->assertEquals(1, count($messages));

        $mixedValues = array('value' => array('foofor','test'));
        $messages = $this->validation->validate($mixedValues);

        $this->assertEquals(1, count($messages));

        $correctValues = array('value' => array('foobar', '', null));
        $messages = $this->validation->validate($correctValues);

        $this->assertEquals(0, count($messages));
    }
}
