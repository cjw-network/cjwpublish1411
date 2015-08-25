--TEST--
Testing view an exception
--ENV--
return <<<END
REQUEST_METHOD=GET
REQUEST_URI=/
HTTP_ACCEPT=text/html
END;
--FILE--
<?php

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

require __DIR__ . '/../../../../src/main/Qafoo/RMF/bootstrap.php';

class MyException extends \Exception implements \Qafoo\RMF\NotFound
{
}

$view = new HtmlJson( new Json() );

$view->display( new Request\HTTP(), new MyException( "Hello world" ) );

--EXPECTHEADERS--
Status: 404 Not Found
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
    <pre>{
  "error"  : <span style="color: #a40000;">&quot;Not Found&quot;</span>,
  "type"   : <span style="color: #204a87;">404</span>,
  "message": <span style="color: #a40000;">&quot;Hello world&quot;</span>,
}</pre>
</body>
</html>
