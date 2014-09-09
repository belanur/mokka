<?php
namespace Mokka\PHPUnit;

use Mokka\Method\Invokation\ExpectedInvokationCount;
use Mokka\Mock\MockInterface;
use Mokka\Mokka;

class MokkaTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $classname
     * @return \Mokka\Mock\Mock
     */
    public function mock($classname)
    {
        return Mokka::mock($classname);
    }

    /**
     * @param MockInterface $mock
     * @return MockInterface
     */
    public function when(MockInterface $mock)
    {
        return Mokka::when($mock);
    }

    /**
     * @param MockInterface $mock
     * @param null|int|ExpectedInvokationCount $expectedInvokationCount
     * @return MockInterface
     */
    public function verify(MockInterface $mock, $expectedInvokationCount = NULL)
    {
        /* Workaround for PHPUnit Warning "This test did not perform any assertions".
         * A verification on a mock object is some kind of assertion
         */
        $this->assertTrue(TRUE);
        return Mokka::verify($mock, $expectedInvokationCount);
    }
} 