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
use Vegas\Tests\Stub\Models\FakeForm;
use Vegas\Tests\Stub\Models\FakeModel;

class CloneableTest extends \PHPUnit_Framework_TestCase
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

    public function testValues()
    {
        $cloneable = $this->prepareValidCloneableField();

        $this->form->add($cloneable);

        $this->assertFalse($this->form->isValid(array('cloneable_field' => array(
            array('test1' => ''),
            array('test1' => '')
        ))));

        $this->assertFalse($this->form->isValid(array('cloneable_field' => array(
            array('test1' => ''),
            array('test1' => 'bar')
        ))));

        $this->assertTrue($this->form->isValid(array('cloneable_field' => array(
            array('test1' => 'foo'),
            array('test1' => 'bar'),
            array('test1' => 'baz'),
        ))));
    }

    private function prepareValidCloneableField()
    {
        $textField = new \Phalcon\Forms\Element\Text('test1');
        $textField->addValidator(new \Phalcon\Validation\Validator\PresenceOf());

        $cloneable = new Cloneable('cloneable_field');
        $cloneable->setAssetsManager($this->di->get('assets'));
        $cloneable->setBaseElements(array($textField));

        return $cloneable;
    }
}
