<?php

namespace Tests;

use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    public function __construct()
    {
        parent::__construct();
        require __DIR__ . '/../config/bootstrap.php';
    }

    public function getProperty(&$object, string $property)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $test = $reflection->getProperty($property);
        $test->setAccessible(true);
        return $test->getValue($object);
    }

    public function setProperty(&$object, string $property, mixed $value)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $test = $reflection->getProperty($property);
        $test->setAccessible(true);
        return $test->setValue($object, $value);
    }

    //used to realize tests in private methods
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function getConstants($class)
    {
        $reflection = new \ReflectionClass($class);
        return $reflection->getConstants();
    }
}
