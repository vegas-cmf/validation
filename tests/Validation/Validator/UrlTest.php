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

use Vegas\Validation\Validator\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('url', new Url());
    }

    public function testSingleInput()
    {
        $badFormatValue = array('url' => 'not an url');
        $messages = $this->validation->validate($badFormatValue);

        $this->assertEquals(1, count($messages));

        $notHttpValue = array('url' => 'www.domain.som');
        $messages = $this->validation->validate($notHttpValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('url' => 'http://www.test.com');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));

        $correctHttpsValue = array('url' => 'https://www.test.com');
        $messages = $this->validation->validate($correctHttpsValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badFormatValues = array(
            'url' => array(
                0 => 'not an url',
                1 => '348490239'
            )
        );
        $messages = $this->validation->validate($badFormatValues);
        $this->assertEquals(1, count($messages));

        $mixedValues = array(
            'url' => array(
                0 => 'http://www.some.other',
                1 => 'not an url'
            )
        );
        $messages = $this->validation->validate($mixedValues);
        $this->assertEquals(1, count($messages));

        $correctValues = array(
            'url' => array(
                0 => 'https://www.test.net',
                1 => 'http://www.other-test.nl'
            )
        );
        $messages = $this->validation->validate($correctValues);
        $this->assertEquals(0, count($messages));
    }
}
