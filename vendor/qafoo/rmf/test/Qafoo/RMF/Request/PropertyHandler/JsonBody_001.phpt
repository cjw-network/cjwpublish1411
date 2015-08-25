--TEST--
Parsing JSON body in property handler
--POST_RAW--
"Hello world."
--FILE--
<?php

namespace Qafoo\RMF\Request\PropertyHandler;

require __DIR__ . '/../../../../../src/main/Qafoo/RMF/bootstrap.php';

$handler = new JsonBody();
var_dump( $handler->getValue() );

--EXPECT--
string(12) "Hello world."
