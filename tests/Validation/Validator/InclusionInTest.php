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

use Vegas\Validation\Validator\InclusionIn;

class InclusionInTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();

        $validator = new InclusionIn(array('domain' => array(1, 'abc', '<oreo>')));
        $this->validation->add('value', $validator);
    }

    public function testSingleInput()
    {
        $inRangeValueIntAsString = array('value' => '1');
        $messages = $this->validation->validate($inRangeValueIntAsString);

        $this->assertEquals(0, count($messages));

        $inRangeValue = array('value' => 'abc');
        $messages = $this->validation->validate($inRangeValue);

        $this->assertEquals(0, count($messages));

        $outOfRangeValue = array('value' => 'foobar');
        $messages = $this->validation->validate($outOfRangeValue);

        $this->assertEquals(1, count($messages));
    }

    public function testArrayInput()
    {
        $inRangeValues = array('value' => array('abc', '<oreo>'));
        $messages = $this->validation->validate($inRangeValues);

        $this->assertEquals(0, count($messages));

        $mixedValues = array('value' => array('abc', 3));
        $messages = $this->validation->validate($mixedValues);

        $this->assertEquals(1, count($messages));

        $outOfRangeValues = array('value' => array('1.1', 'oreo'));
        $messages = $this->validation->validate($outOfRangeValues);

        $this->assertEquals(1, count($messages));
    }
}
