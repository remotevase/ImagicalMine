<?php
/**
 * src/pocketmine/scheduler/AsyncTask.php
 *
 * @package default
 */


/*
 *
 *  _                       _           _ __  __ _
 * (_)                     (_)         | |  \/  (_)
 *  _ _ __ ___   __ _  __ _ _  ___ __ _| | \  / |_ _ __   ___
 * | | '_ ` _ \ / _` |/ _` | |/ __/ _` | | |\/| | | '_ \ / _ \
 * | | | | | | | (_| | (_| | | (_| (_| | | |  | | | | | |  __/
 * |_|_| |_| |_|\__,_|\__, |_|\___\__,_|_|_|  |_|_|_| |_|\___|
 *                     __/ |
 *                    |___/
 *
 * This program is a third party build by ImagicalMine.
 *
 * ImagicalMine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author ImagicalMine Team
 * @link http://forums.imagicalcorp.ml/
 *
 *
*/

namespace pocketmine\scheduler;

use pocketmine\Server;
use pocketmine\Collectable;

/**
 * Class used to run async tasks in other threads.
 *
 * WARNING: Do not call ImagicalMine API methods, or save objects from/on other Threads!!
 */
abstract class AsyncTask extends Collectable
{

    /** @var AsyncWorker $worker */
    public $worker = null;

    private $result = null;
    private $serialized = false;
    private $cancelRun = false;
    /** @var int */
    private $taskId = null;

    private $crashed = false;

    /**
     *
     */
    public function run()
    {
        $this->result = null;

        if ($this->cancelRun !== true) {
            try {
                $this->onRun();
            } catch (\Throwable $e) {
                $this->crashed = true;
                $this->worker->handleException($e);
            }
        }

        $this->setGarbage();
    }



    /**
     *
     * @return unknown
     */
    public function isCrashed()
    {
        return $this->crashed;
    }


    /**
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->serialized ? unserialize($this->result) : $this->result;
    }


    /**
     *
     */
    public function cancelRun()
    {
        $this->cancelRun = true;
    }


    /**
     *
     * @return unknown
     */
    public function hasCancelledRun()
    {
        return $this->cancelRun === true;
    }


    /**
     *
     * @return bool
     */
    public function hasResult()
    {
        return $this->result !== null;
    }


    /**
     *
     * @param mixed   $result
     * @param bool    $serialize (optional)
     */
    public function setResult($result, $serialize = true)
    {
        $this->result = $serialize ? serialize($result) : $result;
        $this->serialized = $serialize;
    }


    /**
     *
     * @param unknown $taskId
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
    }


    /**
     *
     * @return unknown
     */
    public function getTaskId()
    {
        return $this->taskId;
    }


    /**
     * Gets something into the local thread store.
     * You have to initialize this in some way from the task on run
     *
     * @param string  $identifier
     * @return mixed
     */
    public function getFromThreadStore($identifier)
    {
        global $store;
        return $this->isGarbage() ? null : $store[$identifier];
    }


    /**
     * Saves something into the local thread store.
     * This might get deleted at any moment.
     *
     * @param string  $identifier
     * @param mixed   $value
     */
    public function saveToThreadStore($identifier, $value)
    {
        global $store;
        if (!$this->isGarbage()) {
            $store[$identifier] = $value;
        }
    }


    /**
     * Actions to execute when run
     *
     * @return void
     */
    abstract public function onRun();

    /**
     * Actions to execute when completed (on main thread)
     * Implement this if you want to handle the data in your AsyncTask after it has been processed
     *
     *
     * @param Server  $server
     * @return void
     */
    public function onCompletion(Server $server)
    {
    }


    /**
     *
     */
    public function cleanObject()
    {
        foreach ($this as $p => $v) {
            if (!($v instanceof \Threaded)) {
                $this->{$p} = null;
            }
        }
    }
}
