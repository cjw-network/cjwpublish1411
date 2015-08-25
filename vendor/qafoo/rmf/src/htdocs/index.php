<?php

namespace Qafoo\RMF;

spl_autoload_register(
    function( $class )
    {
        if ( 0 === strpos( $class, __NAMESPACE__ ) )
        {
            include __DIR__ . '/../main/' . strtr( $class, '\\', '/' ) . '.php';
        }
    }
);

$dispatcher = new Dispatcher\Simple(
    new Router\Regexp( array(
        '(/)' => array(
            'GET' => function() {
                return "Hello world";
            }
        )
    ) ),
    new View\HtmlJson(
        new View\Json()
    )
);

$dispatcher->dispatch( new Request\HTTP() );

