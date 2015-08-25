--TEST--
Testing complex struct
--ENV--
return <<<END
REQUEST_METHOD=GET
REQUEST_URI=/
HTTP_ACCEPT=application/xhtml
END;
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

$view = new HtmlJson( new Json() );
$view->display( new Request\HTTP(), array(
    array(
        'null'  => null,
        'true'  => true,
        'false' => false,
        'int'   => 42,
        'float' => 23.5,
        'array' => array( 1, 2, 3 ),
    )
) );

--EXPECTHEADERS--
Content-Type: text/html
--EXPECT--
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>GET /</title>
</head>
<body>
    <h1>GET /</h1>
    <pre>[
  {
    "null" : <span style="color: #5c3566;">null</span>,
    "true" : <span style="color: #5c3566;">true</span>,
    "false": <span style="color: #5c3566;">false</span>,
    "int"  : <span style="color: #204a87;">42</span>,
    "float": <span style="color: #204a87;">23.5</span>,
    "array": [
      <span style="color: #204a87;">1</span>,
      <span style="color: #204a87;">2</span>,
      <span style="color: #204a87;">3</span>,
    ],
  },
]</pre>
</body>
</html>
