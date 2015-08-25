--TEST--
Testing view with trivial null value
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

$view = new Json();
$view->display( new Request(), null );

--EXPECTHEADERS--
Content-Type: application/json
--EXPECT--
null
