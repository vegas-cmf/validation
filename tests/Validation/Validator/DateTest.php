<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniołek <mateusz.aniolek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Tests\Validation\Validator;

use Vegas\Validation\Validator\Date;

class DateTest extends \PHPUnit_Framework_TestCase
{
    protected $validation;

    protected function setUp()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('date', new Date(['format' => 'Y-m-d']));
    }

    public function testSingleInput()
    {
        $badFormatValue = array('date' => '20-11-2014');
        $messages = $this->validation->validate($badFormatValue);
        $this->assertEquals(1, count($messages));

        $correctValue = array('date' => '2014-11-20');
        $messages = $this->validation->validate($correctValue);
        $this->assertEquals(0, count($messages));

        $correctValue = array('date' => '2014-01-01');
        $messages = $this->validation->validate($correctValue);
        $this->assertEquals(0, count($messages));
    }

    /**
     * @expectedException \Vegas\Validation\Validator\Date\Exception\FormatNotSetException
     */
    public function testMissingFormatException()
    {
        $this->validation = new \Phalcon\Validation();
        $this->validation->add('date', new Date());

        $anyFormatValue = array('date' => '20-11-2014');
        $this->validation->validate($anyFormatValue);

    }

}
