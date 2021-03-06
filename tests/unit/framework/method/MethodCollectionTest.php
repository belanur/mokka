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
use Mokka\Comparator\ArgumentComparator;
use Mokka\Comparator\ComparatorLocator;
use Mokka\Method\ArgumentCollection;
use Mokka\Method\Invokation\Once;
use Mokka\Method\MethodCollection;
use Mokka\Method\MockedMethod;
use Mokka\Method\StubbedMethod;

/**
 * @author     Sebastian Heuer <sebastian@phpeople.de>
 * @copyright  Sebastian Heuer <sebastian@phpeople.de>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MethodCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MethodCollection
     */
    private $_collection;

    public function setUp()
    {
        $this->_collection = new MethodCollection(new ArgumentComparator(new ComparatorLocator()));
    }

    public function testAddMethod()
    {
        $this->assertAttributeEmpty('_methods', $this->_collection);
        $method = new MethodMock();
        $this->_collection->addMethod($method);
        $this->assertAttributeEquals(array($method), '_methods', $this->_collection);
    }

    public function testHasMethod()
    {
        $this->_collection->addMethod(new StubbedMethod('doBar', new ArgumentCollection(), 'foo'));
        $this->_collection->addMethod(new StubbedMethod('doFoo', new ArgumentCollection(['foo']), 'foo'));
        $method = new StubbedMethod('doFoo', new ArgumentCollection(), 'foo');
        $this->assertFalse($this->_collection->hasMethod('doFoo', new ArgumentCollection()));
        $this->_collection->addMethod($method);
        $this->assertTrue($this->_collection->hasMethod('doFoo', new ArgumentCollection()));
    }

    /**
     * @expectedException \Mokka\NotFoundException
     */
    public function testGetMethodThrowsExceptionIfMethodWasNotFound()
    {
        $this->_collection->getMethod('doFoo', new ArgumentCollection());
    }

    /**
     * @expectedException \Mokka\NotFoundException
     */
    public function testGetMethodTHrowsExceptionIfArgumentCollectionsDoNotMatch()
    {
        $method = new StubbedMethod('doFoo', new ArgumentCollection(['foo']), 'foo');
        $this->_collection->addMethod($method);
        $this->_collection->getMethod('doFoo', new ArgumentCollection());
    }

    public function testGetMethod()
    {
        $this->_collection->addMethod(new StubbedMethod('doBar', new ArgumentCollection(), 'foo'));
        $method = new StubbedMethod('doFoo', new ArgumentCollection(), 'foo');
        $this->_collection->addMethod($method);
        $this->assertSame($method, $this->_collection->getMethod('doFoo', new ArgumentCollection()));
    }

    public function testCount()
    {
        $this->assertSame(0, $this->_collection->count());
        $this->_collection->addMethod(new StubbedMethod('doBar', new ArgumentCollection(), 'foo'));
        $this->assertSame(1, $this->_collection->count());
        $this->_collection->addMethod(new StubbedMethod('doFoo', new ArgumentCollection(), 'foo'));
        $this->assertSame(2, $this->_collection->count());
    }


}
