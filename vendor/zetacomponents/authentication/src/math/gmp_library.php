<?php
/**
 * File containing the ezcAuthenticationGmpLibrary class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Wrapper class for the PHP gmp extension.
 *
 * @package Authentication
 * @version //autogen//
 * @access private
 */
class ezcAuthenticationGmpLibrary extends ezcAuthenticationBignumLibrary
{
    /**
     * Creates a new big number from $number in the base $base.
     *
     * The number $number can be integer or string.
     *
     * @param mixed $number The number from which to create the result
     * @param int $base The base in which the result will be
     * @return resource
     */
    public function init( $number, $base = 10 )
    {
        return gmp_init( $number, $base );
    }

    /**
     * Adds two numbers.
     *
     * @param resource $a The first number
     * @param resource $b The second number
     * @return resource
     */
    public function add( $a, $b )
    {
        return gmp_add( $a, $b );
    }

    /**
     * Substracts two numbers.
     *
     * @param resource $a The first number
     * @param resource $b The second number
     * @return resource
     */
    public function sub( $a, $b )
    {
        return gmp_sub( $a, $b );
    }

    /**
     * Multiplies two numbers.
     *
     * @param resource $a The first number
     * @param resource $b The second number
     * @return resource
     */
    public function mul( $a, $b )
    {
        return gmp_mul( $a, $b );
    }

    /**
     * Divides two numbers.
     *
     * @param resource $a The first number
     * @param resource $b The second number
     * @return resource
     */
    public function div( $a, $b )
    {
        return gmp_div_q( $a, $b );
    }

    /**
     * Computes $base modulo $modulus.
     *
     * @param resource $base The number to apply modulo to
     * @param resource $modulus The modulo value to be applied to $base
     * @return resource
     */
    public function mod( $base, $modulus )
    {
        return gmp_mod( $base, $modulus );
    }

    /**
     * Computes $base to the power of $exponent.
     *
     * Warning! The $exponent cannot be a GMP number resource! It must be an
     * integer (or a string as it would be converted to an integer).
     *
     * @param resource $base The number to be exponentiated
     * @param int $exponent The exponent to apply to $base
     * @return resource
     */
    public function pow( $base, $exponent )
    {
        return gmp_pow( $base, $exponent );
    }

    /**
     * Computes $base to the power of $exponent and then applies modulo $modulus.
     *
     * Warning! The $exponent cannot be a GMP number resource! It must be an
     * integer or a string.
     *
     * @param resource $base The number to be exponentiated
     * @param int $exponent The exponent to apply to $base
     * @param resource $modulus The modulo value to be applied to the result
     * @return resource
     */
    public function powmod( $base, $exponent, $modulus )
    {
        return gmp_powm( $base, $exponent, $modulus );
    }

    /**
     * Computes the inverse of $number in modulo $modulus.
     *
     * @param resource $number The number for which to calculate the inverse
     * @param resource $modulus The modulo value in which the inverse is calculated
     * @return resource
     */
    public function invert( $number, $modulus )
    {
        return gmp_invert( $number, $modulus );
    }

    /**
     * Finds the greatest common denominator of two numbers using the extended
     * Euclidean algorithm.
     *
     * The returned array is ( a0, b0, gcd( a, b ) ), where
     *     a0 * a + b0 * b = gcd( a, b )
     *
     * @param resource $a The first number
     * @param resource $b The second number
     * @return array(resource)
     */
    public function gcd( $a, $b )
    {
        $result = gmp_gcdext( $a, $b );
        return array( $result['s'], $result['t'], $result['g'] );
    }

    /**
     * Compares two numbers.
     *
     * Returns an integer:
     *  - a positive value if $a > $b
     *  - zero if $a == $b
     *  - a negative value if $a < $b
     *
     * @param resource $a The first number
     * @param resource $b The second number
     * @return int
     */
    public function cmp( $a, $b )
    {
        return gmp_cmp( $a, $b );
    }

    /**
     * Returns the string representation of number $a.
     *
     * @param resource $a The number to be represented as a string
     * @return string
     */
    public function toString( $a )
    {
        return gmp_strval( $a );
    }
}
?>
