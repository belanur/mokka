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
namespace Mokka\Tests;

use Mokka\Method\AnythingArgument;
use Mokka\Method\Invokation\AtLeast;
use Mokka\Method\Invokation\Exactly;
use Mokka\Method\Invokation\Never;
use Mokka\Method\Invokation\Once;
use Mokka\Mock\MockInterface;
use Mokka\Mokka;

/**
 * @author     Sebastian Heuer <sebastian@phpeople.de>
 * @copyright  Sebastian Heuer <sebastian@phpeople.de>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MokkaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mokka
     */
    private $_mokka;

    public function setUp()
    {
        $this->_mokka = new Mokka();
    }

    public function testWhenLetsMockListen()
    {
        $mock = $this->getMock('\Mokka\Mock\MockInterface');
        $mock->expects($this->once())
            ->method('listenForStub');
        $this->_mokka->when($mock);
    }

    public function testVerifyLetsMockListen()
    {
        $mock = $this->getMock('\Mokka\Mock\MockInterface');
        $mock->expects($this->once())
            ->method('listenForVerification');
        $this->_mokka->verify($mock);
    }

    public function testWhenReturnsMock()
    {
        $mock = new MockStub();
        $this->assertSame($mock, $this->_mokka->when($mock));
    }

    /**
     * Since Mokka::mock() is static, this tests relies on the
     * correct function of the MockBuilder class
     */
    public function testMockReturnsExpectedMockObject()
    {
        $mock = Mokka::mock('\Mokka\Tests\ClassStub');
        $this->assertInstanceOf('\Mokka\Tests\ClassStub', $mock);
        $this->assertInstanceOf('\Mokka\Mock\MockInterface', $mock);
    }

    public function testInvocationProxyMethods()
    {
        $this->assertEquals(new Once(), Mokka::once());
        $this->assertEquals(new AtLeast(3), Mokka::atLeast(3));
        $this->assertEquals(new Exactly(2), Mokka::exactly(2));
        $this->assertEquals(new AnythingArgument(), Mokka::anything());
        $this->assertEquals(new Never(), Mokka::never());
    }
}
