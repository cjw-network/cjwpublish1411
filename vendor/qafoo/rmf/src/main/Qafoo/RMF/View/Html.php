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
 * Simple PHP based Html view class.
 *
 * This view class utilizes simple PHP based templates to render a Html page.
 *
 * @version $Revision$
 */
class Html extends View
{
    /**
     * Mapping of HTTP status codes to error names
     *
     * @var array
     */
    protected $errors = array(
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        409 => 'Conflict',
        500 => 'Internal Server Error',
    );

    /**
     * The template root directory.
     *
     * @var string
     */
    protected $templateDir = '';

    /**
     * The default error template.
     *
     * @var string
     */
    protected $errorTemplate;

    /**
     * Constructs a new view instance.
     *
     * @param string $templateDir
     * @param string $errorTemplate
     */
    public function __construct( $templateDir, $errorTemplate = 'error.phtml' )
    {
        $this->templateDir   = realpath( rtrim( $templateDir, '/\\' ) ) . '/';
        $this->errorTemplate = $errorTemplate;
    }

    /**
     * Display the controller result
     *
     * @param \Qafoo\RMF\Request $request
     * @param mixed $result
     *
     * @return void
     */
    public function display( Request $request, $result )
    {
        header( 'Content-Type: text/html' );
        if ( !$result instanceof \Exception )
        {
            if ( is_string( $result ) )
            {
                echo $result;
            }
            else if ( isset( $result['template'] ) )
            {
                $this->render(
                    $result['template'],
                    $result['data']
                );
            }
            return;
        }

        switch ( true )
        {
            case $result instanceof \Qafoo\RMF\BadRequest:
                $type = 400;
                break;

            case $result instanceof \Qafoo\RMF\NotFound:
                $type = 404;
                break;

            case $result instanceof \Qafoo\RMF\Conflict:
                $type = 409;
                break;

            default:
                $type = 500;
        }

        header( "Status: $type " . $this->errors[$type] );
        $this->render(
            $this->errorTemplate,
            array(
                'error'   =>  $this->errors[$type],
                'type'    =>  $type,
                'message' => method_exists( $result, 'getMessage') ? $result->getMessage() : '',
            )
        );
    }

    /**
     * Will render the given template and output it's content directly.
     *
     * @param string $template
     * @param array|object $result
     *
     * @return void
     */
    public function render( $template, $result = null )
    {
        $template = realpath( $this->templateDir . $template );

        if ( 0 === strpos( $template, $this->templateDir ) )
        {
            $workingDir = getcwd();

            chdir( dirname( $template ) );

            if ( is_array( $result ) )
            {
                extract( $result );
            }
            else if ( is_object( $result ) )
            {
                foreach ( get_object_vars( $result ) as $name => $value )
                {
                    $$name = $value;
                }
            }

            include $template;

            chdir( $workingDir );
        }
    }
}
