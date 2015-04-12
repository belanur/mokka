<?php
/**
 * Copyright (c) 2014, 2015 Sebastian Heuer <belanur@gmail.com>
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

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MockTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param \ReflectionMethod $method
     * @param string $parameterName
     */
    public function assertParameterIsArray(\ReflectionMethod $method, $parameterName)
    {
        $this->assertTrue($this->_getParameter($method, $parameterName)->isArray());
    }

    /**
     * @param \ReflectionMethod $method
     * @param string $parameterName
     * @param string $type
     */
    public function assertParameterHasType(\ReflectionMethod $method, $parameterName, $type)
    {
        $this->assertEquals($type, $this->_getParameter($method, $parameterName)->getClass()->getName());
    }

    /**
     * @param \ReflectionMethod $method
     * @param string $parameterName
     * @param mixed $value
     */
    public function assertParameterHasDefaultValue(\ReflectionMethod $method, $parameterName, $value)
    {
        $this->assertEquals($value, $this->_getParameter($method, $parameterName)->getDefaultValue());
    }

    /**
     * @param \ReflectionMethod $method
     * @param string $parameterName
     * @return \ReflectionParameter
     */
    private function _getParameter(\ReflectionMethod $method, $parameterName)
    {
        foreach ($method->getParameters() as $parameter) {
            if ($parameter->getName() == $parameterName) {
                return $parameter;
            }
        }
        $this->fail(sprintf('Parameter %s in Method %s not found', $parameterName, $method->getName()));
    }


} 
