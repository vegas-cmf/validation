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

use Vegas\Validation\Validator\Ip;

class IpTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('ip', new Ip());
    }

    public function testSingleInput()
    {
        $badFormatValue = array('ip' => 'not an ip');
        $messages = $this->validation->validate($badFormatValue);

        $this->assertEquals(1, count($messages));

        $notExistingIpValue = array('ip' => '321.439.312.123');
        $messages = $this->validation->validate($notExistingIpValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('ip' => '192.168.0.1');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badFormatValues = array(
            'ip' => array(
                0 => 'not an ip',
                1 => 'www.test.nl'
            )
        );
        $messages = $this->validation->validate($badFormatValues);
        $this->assertEquals(1, count($messages));

        $mixedValues = array(
            'ip' => array(
                0 => '123.0.0.1',
                1 => '123001'
            )
        );
        $messages = $this->validation->validate($mixedValues);
        $this->assertEquals(1, count($messages));

        $correctValues = array(
            'ip' => array(
                0 => '255.255.255.255',
                1 => '192.168.12.11'
            )
        );
        $messages = $this->validation->validate($correctValues);
        $this->assertEquals(0, count($messages));
    }
}
