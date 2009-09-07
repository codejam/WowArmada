<?php
/**
 * This program is free software: you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * WowItemDBFactory Class
 *
 * A factory class that provides item database adapter required to build links to item, spell, etc.
 *
 * Copyright (C) <2009>  <codejam>
 */

class WowItemDBFactory {

    /**
     * The Blizzard Armory WowItemDBAdapter object
     * @var WowItemDBAdapter wowHeadAdapter
     */
	private static $armoryAdapter = NULL;
	
    /**
     * The WowHead WowItemDBAdapter object
     * @var WowItemDBAdapter wowHeadAdapter
     */
	private static $wowHeadAdapter = NULL;
	
    /**
     * The Thottbot WowItemDBAdapter object
     * @var WowItemDBAdapter wowHeadAdapter
     */
	private static $thottbotAdapter = NULL;
	
    /**
     * The Allakhazam WowItemDBAdapter object
     * @var WowItemDBAdapter wowHeadAdapter
     */
	private static $allakhazamAdapter = NULL;
	
    /**
     * The WowDB WowItemDBAdapter object
     * @var WowItemDBAdapter wowHeadAdapter
     */
	private static $wowDBAdapter = NULL;
	
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     */
    public function __construct(){
    }
	
   /*
    * Returns the instance of the Armory WowItemDBAdapter object used
    * to build links to world of warcraft objects.
    *
    * The method is build using the singleton pattern. The same instance is
    * shared amongst multiple call to this method.
    *
    * @return WowItemDBAdapter, the Armory item link builder
    */
    public static function  buildArmoryItemDBAdapter(){
	    if(empty(WowItemDBFactory::$armoryAdapter)){
		  WowItemDBFactory::$armoryAdapter = new WowItemDBAdapter("http://www.wowarmory.com/",
		  												"item-info.xml?i=%s",
		  												"",
		  												"",
		  												"",
		  												"");
	    } 
	    return WowItemDBFactory::$armoryAdapter;
    }
    
   /*
    * Returns the instance of the WowHead WowItemDBAdapter object used
    * to build links to world of warcraft objects.
    *
    * The method is build using the singleton pattern. The same instance is
    * shared amongst multiple call to this method.
    *
    * @return WowItemDBAdapter, the WowHead item link builder
    */
    public static function  buildWowHeadItemDBAdapter(){
	    if(empty(WowItemDBFactory::$wowHeadAdapter)){
		  WowItemDBFactory::$wowHeadAdapter = new WowItemDBAdapter("http://www.wowhead.com/",
		  												"?item=%s",
		  												"?spell=%s",
		  												"?quest=%s",
		  												"?achievement=%s",
		  												"http://www.wowhead.com/widgets/power.js");
	    } 
	    return WowItemDBFactory::$wowHeadAdapter;
    }
    
   /*
    * Returns the instance of the Thottbot WowItemDBAdapter object used
    * to build links to world of warcraft objects.
    *
    * The method is build using the singleton pattern. The same instance is
    * shared amongst multiple call to this method.
    *
    * @return WowItemDBAdapter, the Thottbot item link builder
    */
    public static function  buildThottbotItemDBAdapter(){
	    if(empty(WowItemDBFactory::$thottbotAdapter)){
		  WowItemDBFactory::$thottbotAdapter = new WowItemDBAdapter("http://thottbot.com/",
		  												"i%s",
		  												"s%s",
		  												"q%s",
		  												"ach%s",
		  												"http://i.thottbot.com/power.js");
	    } 
	    return WowItemDBFactory::$thottbotAdapter;
    }
    
   /*
    * Returns the instance of the Allakhazam WowItemDBAdapter object used
    * to build links to world of warcraft objects.
    *
    * The method is build using the singleton pattern. The same instance is
    * shared amongst multiple call to this method.
    *
    * @return WowItemDBAdapter, the Allakhazam item link builder
    */
    public static function  buildAllakhazamItemDBAdapter(){
	    if(empty(WowItemDBFactory::$allakhazamAdapter)){
		  WowItemDBFactory::$allakhazamAdapter = new WowItemDBAdapter("http://wow.allakhazam.com/",
		  												"db/item.html?witem=%s",
		  												"db/spell.html?wspell=%s",
		  												"db/quest.html?wquest=%s",
		  												"",
		  												"http://common.allakhazam.com/shared/akztooltip.js");
	    } 
	    return WowItemDBFactory::$allakhazamAdapter;
    }
    
       /*
    * Returns the instance of the WowDB WowItemDBAdapter object used
    * to build links to world of warcraft objects.
    *
    * The method is build using the singleton pattern. The same instance is
    * shared amongst multiple call to this method.
    * Note: http://wow.allakhazam.com/ihtml?%s
    * @return WowItemDBAdapter, the WowDB item link builder
    */
    public static function  buildWowDBItemDBAdapter(){
	    if(empty(WowItemDBFactory::$wowDBAdapter)){
		  WowItemDBFactory::$wowDBAdapter = new WowItemDBAdapter("http://www.wowdb.com/",
		  												"item.aspx?id=%s",
		  												"spell.aspx?id=%s",
		  												"quest.aspx?id=%s",
		  												"achievement.aspx?id=%s",
		  												"http://www.wowdb.com/js/extooltips.js");
	    } 
	    return WowItemDBFactory::$wowDBAdapter;
    }
    
    
}

?>
