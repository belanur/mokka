<?php
/**
 * Copyright (c) 2014, 2015 Sebastian Heuer <sebastian@phpeople.de>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Sebastian Heuer nor the names of contributors
 *     may be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 */
namespace Mokka\Tests\Integration;

use Mokka\Mock\MockInterface;
use Mokka\Mokka;
use Mokka\Tests\Integration\Fixtures\FooInterface;
use Mokka\Tests\Integration\Fixtures\SampleClass;

/**
 * @author     Sebastian Heuer <sebastian@phpeople.de>
 * @copyright  Sebastian Heuer <sebastian@phpeople.de>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MockTest extends MockTestCase
{
    /**
     * @var SampleClass|MockInterface
     */
    private $_mock;

    public function setUp()
    {
        $this->_mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
    }

    /**
     * @testdox mocked magic methods (like __construct()) have no parameters
     *
     * @dataProvider magicMethodProvider
     * @param string $method
     */
    public function testMockedMagicMethodHasNoParameters($method)
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, $method);
        $this->assertEquals(0, $mockedMethod->getNumberOfParameters());
    }

    public static function magicMethodProvider()
    {
        return array(
            array('__construct'),
            array('__destruct'),
        );
    }

    /**
     * @testdox mocked method contains the array parameter of the original method
     */
    public function testMockedMethodHasArrayParam()
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, 'setFoos');
        $this->assertEquals(1, $mockedMethod->getNumberOfParameters());
        $this->assertParameterIsArray($mockedMethod, 'foos');
    }

    /**
     * @testdox mocked method contains the parameter type of the original method
     */
    public function testMockedMethodHasClassParam()
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, 'setFoo');
        $this->assertEquals(1, $mockedMethod->getNumberOfParameters());
        $this->assertParameterHasType($mockedMethod, 'foo', 'Mokka\Tests\Integration\Fixtures\Foo');
    }

    /**
     * @testdox mocked method contains the optional parameter of the original method
     */
    public function testMockedMethodHasOptionalParameter()
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, 'setBar');
        $this->assertParameterHasDefaultValue($mockedMethod, 'bar', NULL);

        $mockedMethod = new \ReflectionMethod($this->_mock, 'setBaz');
        $this->assertParameterHasDefaultValue($mockedMethod, 'baz', 'baz');
    }

    public function testMocksInterface()
    {
        /** @var FooInterface|MockInterface $mock */
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\FooInterface');
        $this->assertNull($mock->getFoo());
    }

    public function testAllowsCombinationOfMockAndStub()
    {
        Mokka::verify($this->_mock)->setBar();
        Mokka::when($this->_mock)->setBar()->thenReturn(TRUE);
        $this->assertTrue($this->_mock->setBar());
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testThrowsExceptionIfCombinedMockAndStubWasNotCalled()
    {
        Mokka::verify($this->_mock)->setBar();
        Mokka::when($this->_mock)->setBar()->thenReturn(TRUE);
        unset($this->_mock);
    }

    public function testStubbedMethodWithAnythingParameter()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::when($mock)->setFoobar('foo', Mokka::anything())->thenReturn('bar');
        $this->assertEquals('bar', $mock->setFoobar('foo', 'bar'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubbedMethodThrowsException()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::when($mock)->setBar()->thenThrow(new \InvalidArgumentException());
        $mock->setBar();
    }

} 
