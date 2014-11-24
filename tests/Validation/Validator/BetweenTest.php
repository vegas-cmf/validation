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

use Vegas\Validation\Validator\Between;

class BetweenTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();

        $validator = new Between(['min' => 3, 'max' => 4.2]);
        $this->validation->add('value', $validator);
    }

    public function testSingleInput()
    {
        $badFormatValue = array('value' => 'not a number');
        $messages = $this->validation->validate($badFormatValue);

        $this->assertEquals(1, count($messages));

        $outOfRangeValue = array('value' => '4.3');
        $messages = $this->validation->validate($outOfRangeValue);

        $this->assertEquals(1, count($messages));

        $correctValue = array('value' => '4.1');
        $messages = $this->validation->validate($correctValue);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $badFormatValues = array(
            'value' => array(
                0 => '0',
                1 => '#@#M'
            )
        );
        $messages = $this->validation->validate($badFormatValues);
        $this->assertEquals(1, count($messages));

        $mixedValues = array(
            'value' => array(
                0 => '3.3',
                1 => '10'
            )
        );
        $messages = $this->validation->validate($mixedValues);
        $this->assertEquals(1, count($messages));

        $correctValues = array(
            'value' => array(
                0 => '3.88',
                1 => '4'
            )
        );
        $messages = $this->validation->validate($correctValues);
        $this->assertEquals(0, count($messages));
    }
}
