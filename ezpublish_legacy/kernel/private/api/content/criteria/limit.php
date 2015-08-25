<?php
/**
 * File containing ezpContentLimitCriteria class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * This class allows for configuration of an offset/limit based criteria
 * @package API
 */
class ezpContentLimitCriteria implements ezpContentCriteriaInterface
{
    /**
     * Current offset
     * @var int
     */
    private $offset;

    /**
     * Current limit
     * @var int
     */
    private $limit;

    public function __construct()
    {
        $this->offset = 0;
    }

    /**
     * Sets the offset criteria
     * @param $offset
     * @return ezpContentLimitCriteria Current limit criteria object
     */
    public function offset( $offset )
    {
        $offset = (int)$offset;
        if( $offset >= 0 )
            $this->offset = $offset;

        return $this;
    }

    /**
     * Sets the limit criteria
     * @param $limit
     * @return ezpContentLimitCriteria Current limit criteria object
     */
    public function limit( $limit )
    {
        $limit = (int)$limit;
        if( $limit > 0 )
            $this->limit = $limit;

        return $this;
    }

    public function translate()
    {
        $aTranslation = array(
            'type'      => 'param',
            'name'      => array( 'Offset', 'Limit' ),
            'value'     => array( $this->offset, $this->limit )
        );

        return $aTranslation;
    }

    public function __toString()
    {
        return 'With offset : '.$this->offset.' / limit : '.$this->limit;
    }
}
?>
