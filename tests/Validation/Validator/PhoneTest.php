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

use Vegas\Validation\Validator\Phone;

class PhoneTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('phone', new Phone());
    }

    public function testSingleInput()
    {
        $badFormatValue = array('phone' => '123-3212-232');
        $messages = $this->validation->validate($badFormatValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('phone' => '+48 123456789');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badFormatValues = array(
            'phone' => array(
                0 => 'not a number',
                1 => 'not a number too'
            )
        );
        $messages = $this->validation->validate($badFormatValues);
        $this->assertEquals(1, count($messages));

        $mixedValues = array(
            'phone' => array(
                0 => '+48 123456789',
                1 => 'not a number too'
            )
        );
        $messages = $this->validation->validate($mixedValues);
        $this->assertEquals(1, count($messages));

        $correctValues = array(
            'phone' => array(
                0 => '+48 123456789',
                1 => '0123 123456789'
            )
        );
        $messages = $this->validation->validate($correctValues);
        $this->assertEquals(0, count($messages));
    }
}
