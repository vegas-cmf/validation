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

use Phalcon\DI;
use Vegas\Forms\Element\Cloneable;
use Vegas\Validation\Validator\SizeOf;
use Vegas\Tests\Stub\Models\FakeForm;
use Vegas\Tests\Stub\Models\FakeModel;

class SizeOfTest extends \PHPUnit_Framework_TestCase
{
    protected $di;
    protected $form;

    protected function setUp()
    {
        $this->di = DI::getDefault();

        $this->form = new FakeForm();
        $this->form->remove('fake_field');

        $cloneable = $this->prepareValidCloneableField();
        $this->form->add($cloneable);
    }

    public function testInvalidInput()
    {
        $model = new FakeModel();

        $this->form->get('cloneable_field')->addValidator(new SizeOf(array('min' => 1, 'max' => 2)));
        $this->form->bind(array('cloneable_field', 'notArrayedValue'), $model);

        $this->assertFalse($this->form->isValid());
        $this->assertTrue((bool)count($this->form->getMessagesFor('cloneable_field')));
    }

    public function testValidInput()
    {
        $model = new FakeModel();

        $this->form->get('cloneable_field')->addValidators(array(
            new SizeOf(array('min' => 1, 'max' => 2))
        ));

        $this->form->bind(array('cloneable_field' => array(
            array('test1' => 'foo', 'test2' => 'bar'),
            array('test1' => 'foo', 'test2' => 'bar'),
            array('test1' => 'foo', 'test2' => 'bar')
        )), $model);

        $this->assertFalse($this->form->isValid());
        $this->assertTrue((bool)count($this->form->getMessagesFor('cloneable_field')));

        $this->form->bind(array('cloneable_field' => array(
            array('test1' => 'foo', 'test2' => 'bar'),
            array('test1' => 'foo', 'test2' => 'bar'),
        )), $model);

        $this->assertTrue($this->form->isValid());

        $this->form->bind(array('cloneable_field' => array(
            array('test1' => 'foo', 'test2' => 'bar')
        )), $model);

        $this->assertTrue($this->form->isValid());

        $this->form->bind(array('cloneable_field' => array(
            array('test1' => 'foo', 'test2' => '')
        )), $model);

        $this->assertTrue($this->form->isValid());

        $this->form->bind(array('cloneable_field' => array(
            array('test1' => '', 'test2' => '')
        )), $model);

        $this->assertFalse($this->form->isValid());
    }

    private function prepareValidCloneableField()
    {
        $cloneable = new Cloneable('cloneable_field');
        $cloneable->setAssetsManager($this->di->get('assets'));
        $cloneable->setBaseElements(array(new \Phalcon\Forms\Element\Text('test1')));
        $cloneable->addBaseElement(new \Phalcon\Forms\Element\Text('test2'));

        return $cloneable;
    }
}
