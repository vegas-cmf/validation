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

use Vegas\Tests\Stub\Models\FakeModel;
use Vegas\Validation\Validator\Unique;

class UniqueTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('unique', new Unique(array('modelName' => 'Vegas\Tests\Stub\Models\FakeModel')));
    }

    public function testException()
    {
        $validation = new \Phalcon\Validation();
        $validation->add('unique', new Unique());

        $values = array('unique' => 'foo');

        try {
            $validation->validate($values);
            throw new \Exception('Not this exception.');
        } catch (\Exception $ex) {
            $this->assertInstanceOf('Vegas\Validation\Validator\Unique\Exception\ModelNameNotSetException', $ex);
        }
    }

    public function testSingleInput()
    {
        $uniqueValue = uniqid();

        $model = new FakeModel();
        $model->unique = $uniqueValue;
        $model->save();

        $values = array('unique' => $uniqueValue);

        $messages = $this->validation->validate($values);
        $this->assertEquals(1, count($messages));

        $model->delete();
        $messages = $this->validation->validate($values);
        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $uniqueValue1 = uniqid();
        $uniqueValue2 = uniqid();

        $model1 = new FakeModel();
        $model1->unique = $uniqueValue1;
        $model1->save();

        $model2 = new FakeModel();
        $model2->unique = $uniqueValue2;
        $model2->save();

        $values = array(
            'unique' => array(
                0 => $uniqueValue1,
                1 => $uniqueValue2
            )
        );
        $messages = $this->validation->validate($values);
        $this->assertEquals(1, count($messages));

        $model2->delete();

        $messages = $this->validation->validate($values);
        $this->assertEquals(1, count($messages));

        $model1->delete();

        $messages = $this->validation->validate($values);
        $this->assertEquals(0, count($messages));
    }
}
