<?php
/**
 * src/pocketmine/block/Planks.php
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
 * PocketMine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author ImagicalMine Team
 * @link http://forums.imagicalcorp.ml/
 *
 *
*/

namespace pocketmine\block;

use pocketmine\item\Tool;

class Planks extends Solid
{
    const OAK = 0;
    const SPRUCE = 1;
    const BIRCH = 2;
    const JUNGLE = 3;
    const ACACIA = 4;
    const DARK_OAK = 5;

    protected $id = self::WOODEN_PLANKS;

    /**
     *
     * @param unknown $meta (optional)
     */
    public function __construct($meta = 0)
    {
        $this->meta = $meta;
    }


    /**
     *
     * @return unknown
     */
    public function getHardness()
    {
        return 2;
    }


    /**
     *
     * @return unknown
     */
    public function getToolType()
    {
        return Tool::TYPE_AXE;
    }


    /**
     *
     * @return unknown
     */
    public function getName()
    {
        static $names = [
            self::OAK => "Oak Wood Planks",
            self::SPRUCE => "Spruce Wood Planks",
            self::BIRCH => "Birch Wood Planks",
            self::JUNGLE => "Jungle Wood Planks",
            self::ACACIA => "Acacia Wood Planks",
            self::DARK_OAK => "Dark Oak Wood Planks",
            "",
            ""
        ];
        return $names[$this->meta & 0x07];
    }
}
