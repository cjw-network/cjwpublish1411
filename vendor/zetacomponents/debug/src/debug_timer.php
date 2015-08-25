<?php
/**
 * File containing the ezcDebugTimer class.
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
 * @package Debug
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * The ezcDebugTimer class holds several timers.
 *
 * The timers can be started and stopped individually. The timer data can be retrieved
 * with the getStructure method.
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugTimer
{
    /**
     * An internal structure which stores sources, groups, and timers.
     *
     * @var array(string=>ezcDebugTimerStruct)
     */
    private $timers;

    /**
     * Similar to {@link $timers} but stores those that are currently running.
     *
     * @var array(string=>ezcDebugTimerStruct)
     */
    private $runningTimers;

    /**
     * The total number of running timers.
     *
     * @var int
     */
    private $totalRunningTimers;

    /**
     * The submitted timer number. 
     *
     * @var int
     */
    private $number = 0;

    /**
     * Constructs a timer object with no timers.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Throws always an {@link ezcBasePropertyNotFoundException}. 
     *
     * @throws ezcBasePropertyNotFoundException
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Throws always an {@link ezcBasePropertyNotFoundException}. 
     *
     * @throws ezcBasePropertyNotFoundException
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function __set( $name, $value )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }


    /**
     * Resets the timer object to its initial state with no timers.
     *
     * @return void
     */
    public function reset()
    {
        $this->timers = array();
        $this->runningTimers = array();
        $this->totalRunningTimers = 0;
    }

    /**
     * Starts the timer identified by $name with the group $group and returns true on success.
     *
     * If the timer was already started false is returned.
     *
     * @param string $name
     * @param string $group
     * @return bool
     */
    public function startTimer( $name, $group )
    {
        if ( !isset( $this->runningTimers[ $name ] ) )
        {
            $this->totalRunningTimers++;
            $this->runningTimers[$name] = new ezcDebugTimerStruct();

            $this->runningTimers[$name]->name = $name;
            $this->runningTimers[$name]->group = $group;
            $this->runningTimers[$name]->switchTime = array();
            $this->runningTimers[$name]->startTime = microtime( true );
            $this->runningTimers[$name]->startNumber = $this->number++;

            return true;
        }

        return false;
    }

    /**
     * Stops the timer $oldName and starts the timer $newName and return true on success.
     *
     * If the timer $oldName does not exist or if it was omitted with several timers running
     * false is returned.
     *
     * @param string $newName
     * @param string|bool $oldName
     * @return bool
     */
    public function switchTimer( $newName, $oldName = false )
    {
        if ( $this->totalRunningTimers < 1 )
        {
            return false;
        }

        if ( $oldName === false )
        {
            if ( $this->totalRunningTimers > 1 )
            {
                return false;
            }

            $oldName = key( $this->runningTimers );
        }

        if ( isset( $this->runningTimers[ $oldName ] ) )
        {
            if ( $newName != $oldName )
            {
                $this->runningTimers[$newName] = $this->runningTimers[$oldName];
                unset( $this->runningTimers[$oldName] );
            }

            $switchStruct = new ezcDebugSwitchTimerStruct();
            $switchStruct->name = $newName;
            $switchStruct->time = microtime( true );

            $this->runningTimers[$newName]->switchTime[] = $switchStruct;
            return true;
        }

        return false;
    }

    /**
     * Stop the timer identified by $name and return true on success.
     *
     * If the timer $name does not exist or if it was omitted with several timers running
     * false is returned. $name can be omitted (false) if only 1 timer is running.
     *
     * @param string|bool $name
     * @return bool
     * @todo Error handling if multiple timers are running.
     */
    public function stopTimer( $name = false )
    {
        if ( $name === false && $this->totalRunningTimers == 1 )
        {
            $name = key( $this->runningTimers );
        }

        if ( isset( $this->runningTimers[ $name ] ) )
        {
            $this->runningTimers[$name]->stopTime = microtime( true );
            $this->runningTimers[$name]->elapsedTime = $this->runningTimers[$name]->stopTime - $this->runningTimers[$name]->startTime;
            $this->runningTimers[$name]->stopNumber = $this->number++;

            $this->timers[] = $this->runningTimers[$name];
            unset( $this->runningTimers[$name] );

            $this->totalRunningTimers--;
            return true;
        }

        return false;
    }

    /**
     * Returns an array with the timer data.
     *
     * @return array(ezcDebugTimerStruct)
     */
    public function getTimeData()
    {
        return $this->timers;
    }
}

?>
