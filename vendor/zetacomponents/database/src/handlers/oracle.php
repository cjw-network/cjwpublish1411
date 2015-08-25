<?php
/**
 * File containing the ezcDbHandlerOracle class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Database
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Oracle driver implementation
 *
 * @see ezcDbHandler
 * @package Database
 * @version //autogentag//
 */

class ezcDbHandlerOracle extends ezcDbHandler
{
    /**
     * Constructs a handler object from the parameters $dbParams.
     *
     * Supported database parameters are:
     * - dbname|database: Database name
     * - user|username:   Database user name
     * - pass|password:   Database user password
     * - charset:         Client character set
     *
     * @param array $dbParams Database connection parameters (key=>value pairs).
     * @throws ezcDbMissingParameterException if the database name was not specified.
     */
    public function __construct( $dbParams )
    {
        $database = null;
        $charset  = null;

        foreach ( $dbParams as $key => $val )
        {
            switch ( $key )
            {
                case 'database':
                case 'dbname':
                    $database = $val;
                    break;
                case 'charset':
                    $charset = $val;
                    break;
            }
        }

        if ( !isset( $database ) )
        {
            throw new ezcDbMissingParameterException( 'database', 'dbParams' );
        }

        $dsn = "oci:dbname=$database";

        if ( isset( $charset ) && $charset )
        {
            $dsn .= ";charset=$charset";
        }

        parent::__construct( $dbParams, $dsn );
    }

    /**
     * Returns 'oracle'.
     *
     * @return string
     */
    static public function getName()
    {
        return 'oracle';
    }

    /**
     * Returns a new ezcQuerySelect derived object with Oracle implementation specifics.
     *
     * @return ezcQuerySelectOracle
     */
    public function createSelectQuery()
    {
        return new ezcQuerySelectOracle( $this );
    }

    /**
     * Returns a new ezcQueryExpression derived object with Oracle implementation specifics.
     *
     * @return ezcQueryExpressionPgsql
     */
    public function createExpression()
    {
        return new ezcQueryExpressionOracle( $this );
    }

    /**
     * Returns a new ezcUtilities derived object with Oracle implementation specifics.
     *
     * @return ezcUtilitiesOracle
     */
    public function createUtilities()
    {
        return new ezcDbUtilitiesOracle( $this );
    }

    /**
     * Returns an SQL query with LIMIT/OFFSET functionality appended.
     *
     * The LIMIT/OFFSET is added to $queryString.
     * $limit controls the maximum number of entries in the resultset.
     * $offset controls where in the resultset results should be
     * returned from.
     *
     * @param string $queryString
     * @param int $limit
     * @param int $offset
     * @return string
     */
    protected function processLimitOffset( $queryString, $limit, $offset )
    {
        if ( isset( $limit ) )
        {
            if ( !isset( $offset ) )
            {
                $offset = 0;
            }

            $min = $offset+1;
            $max = $offset+$limit;

            $queryString = "SELECT * FROM (SELECT a.*, ROWNUM rn FROM ($queryString) a WHERE rownum <= $max) WHERE rn >= $min";
        }

        return $queryString;
    }

    /**
     * Returns $str quoted for the Oracle database.
     *
     * Reimplemented from PDO since PDO is broken using Oracle8.
     *
     * @param string $str
     * @param int $paramStr
     * @return string
     */
    public function quote( $str, $paramStr = PDO::PARAM_STR )
    {
        // looks like PDO::quote() does not work properly with oci8 driver.

        $str = str_replace( "'", "''", $str );
        return "'$str'";
    }
}
?>
