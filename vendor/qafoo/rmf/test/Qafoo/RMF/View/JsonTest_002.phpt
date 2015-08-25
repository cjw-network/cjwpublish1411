--TEST--
Testing view with object structure
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

$view = new Json();

$viewStruct = new \StdClass();
$viewStruct->var = 'Foo';
$view->display( new Request(), $viewStruct );

--EXPECTHEADERS--
Content-Type: application/json
--EXPECT--
{"var":"Foo"}
