--TEST--
Ensure parsing into object notation
--POST_RAW--
{"foo": "bar"}
--FILE--
<?php

namespace Qafoo\RMF\Request\PropertyHandler;

require __DIR__ . '/../../../../../src/main/Qafoo/RMF/bootstrap.php';

$handler = new JsonBody();
print_r( $handler->getValue() );

--EXPECT--
stdClass Object
(
    [foo] => bar
)
