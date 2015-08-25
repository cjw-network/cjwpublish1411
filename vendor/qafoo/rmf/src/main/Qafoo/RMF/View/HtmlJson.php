<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;
use Qafoo\RMF\View;

/**
 * View base class
 *
 * HTML Json view, which delivers reult of the aggregated JSON view per
 * default, but can nicely format it as HTML, if the client prefers that.
 *
 * @version $Revision$
 */
class HtmlJson extends View
{
    /**
     * Aggregated JSON view
     *
     * @var Json
     */
    protected $jsonView;

    /**
     * Construct from JSON view
     *
     * @param Json $jsonView
     * @return void
     */
    public function __construct( Json $jsonView )
    {
        $this->jsonView = $jsonView;
    }

    /**
     * Chack if the client prefers HTML
     *
     * @param Request $request
     * @return bool
     */
    protected function wantsHtml( Request $request )
    {
        foreach ( $request->mimetype as $mimetype )
        {
            if ( strpos( $mimetype['value'], 'json' ) !== false )
            {
                return false;
            }
            elseif ( strpos( $mimetype['value'], 'html' ) !== false )
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Format given contents as HTML marked up JSON
     *
     * @param mixed $data
     * @param integer $indentation
     * @param integer $level
     * @return string
     */
    protected function formatJson( $data, $indentation = 2, $level = 0 )
    {
        switch ( gettype( $data ) )
        {
            case 'NULL':
                return '<span style="color: #5c3566;">null</span>';

            case 'boolean':
                return '<span style="color: #5c3566;">' . ( $data ? 'true' : 'false' ) . '</span>';

            case 'integer':
            case 'double':
                return '<span style="color: #204a87;">' . $data . '</span>';

            case 'string':
                return '<span style="color: #a40000;">&quot;' . $data . '&quot;</span>';

            case 'array':
                $string =  "[\n";
                ++$level;
                foreach ( $data as $value )
                {
                    $string .= str_repeat( ' ', $level * $indentation ) .
                        $this->formatJson( $value, $indentation, $level ) .
                        ",\n";
                }
                --$level;
                return $string . str_repeat( ' ', $level * $indentation ) .  "]";

            case 'object':
                $string =  "{\n";
                ++$level;
                $maxKeyLength = array_reduce( array_map( 'strlen', array_keys( (array) $data ) ), 'max', 0 ) + 2;
                foreach ( $data as $key => $value )
                {
                    $string .= str_repeat( ' ', $level * $indentation ) .
                        str_pad( '"' . $key . '"', $maxKeyLength ) . ': ' .
                        $this->formatJson( $value, $indentation, $level ) .
                        ",\n";
                }
                --$level;
                return $string . str_repeat( ' ', $level * $indentation ) .  "}";
        }
    }

    /**
     * Display the controller result
     *
     * @param Request $request
     * @param mixed $result
     * @return void
     */
    public function display( Request $request, $result )
    {
        if ( !$this->wantsHtml( $request ) )
        {
            $this->jsonView->display( $request, $result );
            return;
        }

        ob_start();
        $this->jsonView->display( $request, $result );
        $data = json_decode( ob_get_clean() );

        header( 'Content-Type: text/html' );
        $highlighted = $this->formatJson( $data );
        echo <<<EOHTML
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$request->method} {$request->path}</title>
</head>
<body>
    <h1>{$request->method} {$request->path}</h1>
    <pre>{$highlighted}</pre>
</body>
</html>
EOHTML;
    }
}

