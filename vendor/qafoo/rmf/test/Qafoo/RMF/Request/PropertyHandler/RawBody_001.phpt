--TEST--
Reading raw body in property handler
--POST_RAW--
"Hello world."
--FILE--
<?php

namespace Qafoo\RMF\Request\PropertyHandler;

require __DIR__ . '/../../../../../src/main/Qafoo/RMF/bootstrap.php';

$handler = new RawBody();
var_dump( $handler->getValue() );

--EXPECT--
string(14) ""Hello world.""
