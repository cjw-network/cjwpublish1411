--TEST--
Testing view an exception
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

$view = new Json();

$view->display( new Request(), new \RuntimeException( "Hello world" ) );

--EXPECTHEADERS--
Status: 500 Internal Server Error
Content-Type: application/json
--EXPECT--
{"error":"Internal Server Error","type":500,"message":"Hello world"}
