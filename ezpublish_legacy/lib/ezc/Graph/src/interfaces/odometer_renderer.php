<?php
/**
 * File containing the ezcGraphOdometerRenderer interface
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Interface which adds the methods required for rendering radar charts to a
 * renderer
 *
 * @version //autogentag//
 * @package Graph
 */
interface ezcGraphOdometerRenderer
{
    /**
     * Render odometer chart
     * 
     * @param ezcGraphBoundings $boundings 
     * @param ezcGraphChartElementAxis $axis
     * @param ezcGraphOdometerChartOptions $options
     * @return ezcGraphBoundings
     */
    public function drawOdometer( 
        ezcGraphBoundings $boundings, 
        ezcGraphChartElementAxis $axis,
        ezcGraphOdometerChartOptions $options
    );

    /**
     * Draw a single odometer marker.
     *
     * @param ezcGraphBoundings $boundings
     * @param ezcGraphCoordinate $position
     * @param int $symbol
     * @param ezcGraphColor $color
     * @param int $width
     */
    public function drawOdometerMarker(
        ezcGraphBoundings $boundings,
        ezcGraphCoordinate $position,
        $symbol,
        ezcGraphColor $color,
        $width
    );
}

?>
