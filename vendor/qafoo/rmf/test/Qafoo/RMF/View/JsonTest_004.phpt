--TEST--
Testing view an exception
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

class MyException extends \Exception implements \Qafoo\RMF\NotFound
{
}

$view = new Json();

$view->display( new Request(), new MyException( "Hello world" ) );

--EXPECTHEADERS--
Status: 404 Not Found
Content-Type: application/json
--EXPECT--
{"error":"Not Found","type":404,"message":"Hello world"}
