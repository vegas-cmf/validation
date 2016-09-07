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

use Vegas\Validation\Validator\InclusionIn;

class InclusionInTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;
    protected $validator;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();

        $this->validator = new InclusionIn(array('domain' => array(1, 'abc', '<oreo>')));
        $this->validation->add('value', $this->validator);
    }

    public function testSingleInput()
    {
        $inRangeValueIntAsString = array('value' => '1');
        $messages = $this->validation->validate($inRangeValueIntAsString);

        $this->assertEquals(0, count($messages));

        $strictComparison = $this->validator->getOption('strict');
        $this->validator->setOption('strict', true);
        $messages = $this->validation->validate($inRangeValueIntAsString);
        $this->assertEquals(1, count($messages));
        $this->validator->setOption('strict', $strictComparison);

        $inRangeValue = array('value' => 'abc');
        $messages = $this->validation->validate($inRangeValue);

        $this->assertEquals(0, count($messages));

        $outOfRangeValue = array('value' => 'foobar');
        $messages = $this->validation->validate($outOfRangeValue);

        $this->assertEquals(1, count($messages));
    }

    public function testEmptyInput()
    {
        $messages = $this->validation->validate(['value' => '']);
        $this->assertEquals(1, count($messages));

        $messages = $this->validation->validate(['value' => null]);
        $this->assertEquals(1, count($messages));

        $this->validator->setOption('allowEmpty', true);

        $messages = $this->validation->validate(['value' => '']);
        $this->assertEquals(0, count($messages));

        $messages = $this->validation->validate(['value' => null]);
        $this->assertEquals(0, count($messages));
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
