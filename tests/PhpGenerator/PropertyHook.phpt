<?php

declare(strict_types=1);

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


$class = new \Nette\PhpGenerator\ClassType('Test');
$property = $class->addProperty("foo");
$getHook = $property->addHook("get");
$getHook->addBody('return $this->first . " " . $this->last;');
$setHook = $property->addHook("set");
$setHook->addParameter("value")->setType("string");
$setHook->addBody('[$this->first, $this->last] = explode(\' \', $value, 2);');
sameFile(__DIR__ . "/expected/PropertyHook.expect", $class->__toString());
