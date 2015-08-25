--TEST--
Testing view fallback to pure JSON
--ENV--
return <<<END
REQUEST_METHOD=GET
REQUEST_URI=/
HTTP_ACCEPT=application/json
END;
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

$view = new HtmlJson( new Json() );
$view->display( new Request\HTTP(), "Hello World!" );

--EXPECTHEADERS--
Content-Type: application/json
--EXPECT--
"Hello World!"
