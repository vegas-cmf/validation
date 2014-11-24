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

use Vegas\Validation\Validator\Identical;

class IdenticalTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('value', new Identical(array('value' => '3.14')));
    }

    public function testSingleInput()
    {
        $badTypeValue = array('value' => 3.14);
        $messages = $this->validation->validate($badTypeValue);

        $this->assertEquals(1, count($messages));

        $badValue = array('value' => '3.142');
        $messages = $this->validation->validate($badValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('value' => '3.14');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badValues = array('value' => array(true, 'foobar'));
        $messages = $this->validation->validate($badValues);

        $this->assertEquals(1, count($messages));

        $mixedValues = array('value' => array('3.14', 'barbaz'));
        $messages = $this->validation->validate($mixedValues);

        $this->assertEquals(1, count($messages));
    }
}
