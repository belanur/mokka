<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mokka\\method\\method' => '/framework/method/Method.php',
                'mokka\\method\\mockedmethod' => '/framework/method/MockedMethod.php',
                'mokka\\method\\stubbedmethod' => '/framework/method/StubbedMethod.php',
                'mokka\\mock\\mock' => '/framework/mock/Mock.php',
                'mokka\\mock\\mockinterface' => '/framework/mock/MockInterface.php',
                'mokka\\mokka' => '/framework/Mokka.php',
                'mokka\\token' => '/framework/Token.php',
                'mokka\\verificationexception' => '/framework/VerificationException.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd