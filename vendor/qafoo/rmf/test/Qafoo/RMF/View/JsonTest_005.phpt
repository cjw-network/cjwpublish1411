--TEST--
Testing view an exception
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

class MyException extends \Exception implements \Qafoo\RMF\Conflict
{
}

$view = new Json();

$view->display( new Request(), new MyException( "Hello world" ) );

--EXPECTHEADERS--
Status: 409 Conflict
Content-Type: application/json
--EXPECT--
{"error":"Conflict","type":409,"message":"Hello world"}
