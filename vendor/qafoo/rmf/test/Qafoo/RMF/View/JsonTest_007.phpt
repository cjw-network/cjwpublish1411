--TEST--
Testing view a bad request exception
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request,
    Qafoo\RMF\BadRequest;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

class BadRequestException extends \RuntimeException implements BadRequest
{
}

$view = new Json();

$view->display( new Request(), new BadRequestException( "Hello world" ) );

--EXPECTHEADERS--
Status: 400 Bad Request
Content-Type: application/json
--EXPECT--
{"error":"Bad Request","type":400,"message":"Hello world"}
