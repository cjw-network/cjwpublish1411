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
 * Dispatcher for various views depending on the mime-type accept header
 *
 * @version $Revision$
 */
class AcceptHeaderViewDispatcher extends View
{
    /**
     * Mapping of regular expressions matching the mime type accept headers to
     * view handlers.
     *
     * @var array
     */
    protected $mapping = array(
    );

    /**
     * Cosntruct from view handler mapping
     *
     * @param array $mapping
     * @return void
     */
    public function __construct( array $mapping )
    {
        foreach ( $mapping as $regexp => $view )
        {
            $this->addViewHandler( $regexp, $view );
        }
    }

    /**
     * Add view handler
     *
     * @param string $regexp
     * @param View $view
     * @return void
     */
    public function addViewHandler( $regexp, View $view )
    {
        $this->mapping[$regexp] = $view;
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
        foreach ( $request->mimetype as $mimetype )
        {
            foreach ( $this->mapping as $regexp => $view )
            {
                if ( preg_match( $regexp, $mimetype['value'] ) )
                {
                    return $view->display( $request, $result );
                }
            }
        }

        throw new NowViewFoundException( "No view mapping found." );
    }
}

