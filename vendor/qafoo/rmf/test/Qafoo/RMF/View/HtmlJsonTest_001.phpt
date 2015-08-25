--TEST--
Testing view with trivial null value
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

$view = new HtmlJson( new Json() );
$view->display( new Request\HTTP(), null );

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
    <pre><span style="color: #5c3566;">null</span></pre>
</body>
</html>
