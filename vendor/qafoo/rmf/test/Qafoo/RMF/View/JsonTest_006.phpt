--TEST--
Testing view with a valid json string
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

$view = new Json();
$view->display( new Request(), '{"foo":42}' );

--EXPECTHEADERS--
Content-Type: application/json
--EXPECT--
{"foo":42}
