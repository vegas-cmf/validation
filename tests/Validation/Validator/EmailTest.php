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

use Vegas\Validation\Validator\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('email', new Email());
    }

    public function testSingleInput()
    {
        $badFormatValue = array('email' => 'bad@email');
        $messages = $this->validation->validate($badFormatValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('email' => 'my.name@is.pota.to');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badFormatValues = array(
            'email' => array(
                0 => 'not an email',
                1 => 'bad@tests'
            )
        );
        $messages = $this->validation->validate($badFormatValues);
        $this->assertEquals(1, count($messages));

        $mixedValues = array(
            'email' => array(
                0 => 'h3j@',
                1 => 'test@test.nl'
            )
        );
        $messages = $this->validation->validate($mixedValues);
        $this->assertEquals(1, count($messages));

        $correctValues = array(
            'email' => array(
                0 => 'vegas@vegas-cmf.test',
                1 => 'this@is.sparta'
            )
        );
        $messages = $this->validation->validate($correctValues);
        $this->assertEquals(0, count($messages));
    }
}
