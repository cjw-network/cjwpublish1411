--TEST--
Parsing JSON body exception
--POST_RAW--
Something unparsable
--FILE--
<?php

namespace Qafoo\RMF\Request\PropertyHandler;

require __DIR__ . '/../../../../../src/main/Qafoo/RMF/bootstrap.php';

try
{
    $handler = new JsonBody();
    var_dump( $handler->getValue() );
}
catch ( JsonBody\ParsingException $e )
{
    echo $e->getMessage();
}

--EXPECT--
Could not parse JSON body: 'Something unparsable'
