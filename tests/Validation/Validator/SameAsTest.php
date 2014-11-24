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

use Vegas\Validation\Validator\SameAs;

class SameAsTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('field1', new SameAs(array('match' => 'field2')));
    }

    public function testException()
    {
        $validation = new \Phalcon\Validation();
        $validation->add('field1', new SameAs());

        $values = array('field1' => 'foo', 'field2' => 'foo');

        try {
            $validation->validate($values);
            throw new \Exception('Not this exception.');
        } catch (\Exception $ex) {
            $this->assertInstanceOf('Vegas\Validation\Validator\SameAs\Exception\MatchNotSetException', $ex);
        }
    }

    public function testSingleInput()
    {
        $values = array('field1' => 'foo', 'field2' => 'bar');
        $messages = $this->validation->validate($values);

        $this->assertEquals(1, count($messages));

        $values = array('field1' => 'foo', 'field2' => 'foo');
        $messages = $this->validation->validate($values);

        $this->assertEquals(0, count($messages));
    }

    public function testArrayInput()
    {
        $values = array(
            'field1' => array(
                0 => 'foo',
                1 => 'bar'
            ),
            'field2' => 'baz'
        );
        $messages = $this->validation->validate($values);
        $this->assertEquals(1, count($messages));

        $values = array(
            'field1' => array(
                0 => 'foo',
                1 => 'bar'
            ),
            'field2' => 'foo'
        );
        $messages = $this->validation->validate($values);
        $this->assertEquals(1, count($messages));

        $values = array(
            'field1' => array(
                0 => 'foo',
                1 => 'foo'
            ),
            'field2' => 'foo'
        );
        $messages = $this->validation->validate($values);
        $this->assertEquals(0, count($messages));
    }
}
