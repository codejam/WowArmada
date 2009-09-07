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
 * WowItemDBAdapter Class
 *
 * An abstract class that defines common procedures and methodsdd to access a wow item database.
 *
 * Copyright (C) <2009>  <codejam>
 */
 
 define("PERMANENT_ENCHANT_XML", "permanentenchant.xml");
 require_once ( dirname( __FILE__ ) . '/WowPermanentEnchantDao.class.php');

class WowItemDBAdapter {

    /**
     * The URL of the item database website
     * @var string itemDatabaseUrl
     */
    private $itemDatabaseUrl = "";
    
    /**
     * The URL of the WowHead website
     * @var string itemDatabaseUrl
     */
    private $itemDatabaseTooltipScriptUrl = "";

    /**
     * The HTTP GET portion to retreive items.
     * This variable contains the "%s" token that should be replaced
     * by the item number.
     * @var string itemGET
     */
    private $itemGET = "";

    /**
     * The HTTP GET portion to retreive spells.
     * This variable contains the "%s" token that should be replaced
     * by the spell number.
     * @var string spellGET
     */
    private $spellGET = "";

    /**
     * The HTTP GET portion to retreive quests.
     * This variable contains the "%s" token that should be replaced
     * by the quest number.
     * @var string questGET
     */
    private $questGET = "";
    
    /**
     * The HTTP GET portion to retreive achievements.
     * This variable contains the "%s" token that should be replaced
     * by the achievements number.
     * @var string achievementGET
     */
    private $achievementGET = "";
    
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param baseUrl string, the item database base url (with ending slash)
     * @param itemGet string, the item get http request that should be appended to base url
     * @param spellGet string, the spell get http request that should be appended to base url
     * @param questGet string, the quest get http request that should be appended to base url
     * @param achievementGet string, the achievement get http request that should be appended to base url
     * @param script string, the script url that should be used for tooltip
     */
    public function __construct($baseUrl, $itemGet, $spellGet, $questGet, $achievementGet, $script){
		$this->itemDatabaseUrl	= $baseUrl;
		$this->itemGET 			= $itemGet;
		$this->spellGET 		= $spellGet;
		$this->questGET 		= $questGet;
		$this->achievementGET 	= $achievementGet;
		$this->itemDatabaseTooltipScriptUrl	= $script;
    }
    
   /*
    * Returns the server url used to fetch information.
    *
    * @return string, the item database server url
    */
    public function getItemDatabaseUrl(){
        return $this->itemDatabaseUrl;
    }

   /*
    * Returns the item database script element that need to be add in the top of the page
    * @return string, the item database tooltip script html element
    */
    public function getItemDatabaseScriptElement(){
	    $result = '';
	    if(!empty($this->itemDatabaseTooltipScriptUrl)){
			$result = '<script type="text/javascript" src="' . $this->itemDatabaseTooltipScriptUrl . '"></script>';
     	}
     	return $result;
    }
    
   /**
    * This function returns the url of an item
    *
    * ex.: http://www.wowhead.com/?item=19019
    * @see http://www.wowhead.com/?forums&topic=3464
    * @param string $itemNumber, the item number provided by the armory
    * @return string, The link to wowhead item description
    */
    public function buildItemURL($itemNumber) {
	    $result = '';
	    if(!empty($itemNumber) && $itemNumber <> 0){
		    $result = $this->itemDatabaseUrl . sprintf($this->itemGET, $itemNumber);
		}
    	return $result;
    }
    
   /**
    * This function returns the url of a spell
    *
    * ex.: http://www.wowhead.com/?spell=18562
    * @see http://www.wowhead.com/?forums&topic=3464
    * @param string $spellNumber, the spell number provided by the armory
    * @return string, The link to wowhead spell description
    */
    public function buildSpellURL($spellNumber) {
	    $result = '';
	    if(!empty($spellNumber) && $spellNumber <> 0){
		    $result = $this->itemDatabaseUrl . sprintf($this->spellGET, $spellNumber);
		}
    	return $result;
    }

   /**
    * This function returns the url of a quest
    *
    * http://www.wowhead.com/?quest=11058
    * @see http://www.wowhead.com/?forums&topic=3464
    * @param string $questNumber, the item number provided by the armory
    * @return string, The link to wowhead quest description
    */
    public function buildQuestURL($questNumber) {
	    $result = '';
	    if(!empty($questNumber) && $questNumber <> 0){
		    $result = $this->itemDatabaseUrl . sprintf($this->questGET, $questNumber);
		}
    	return $result;
    }

   /**
    * This function returns the url of an achievement
    *
    * ex.: http://www.wowhead.com/?item=19019
    * @see http://www.wowhead.com/?forums&topic=3464
    * @param string $achievementNumber, the item number provided by the armory
    * @return string, The link to wowhead achievement description
    */
    public function buildAchievementURL($achievementNumber) {
	    $result = '';
	    if(!empty($achievementNumber) && $achievementNumber <> 0){
		    $result = $this->itemDatabaseUrl . sprintf($this->achievementGET, $achievementNumber);
		}
    	return $result;
    }
    
   /**
    * This function returns the url to an item or a spell on wow head.
    * The spell or item link is determined by a set of data provided by 
    * the armory musings.
    *
    * @see http://okoloth.blogspot.com/2008/12/armory-xml-permanentenchant-attribute.html
    * @param string $permanentEnchantNumber, the permanent enchant number provided by the armory
    * @return string, The link to wowhead item or spell description
    */
    public function buildPermanentEnchantURL($permanentEnchantNumber) {
	    $result = '';
	    if(!empty($permanentEnchantNumber)){
		    $enchantInfos = WowPermanentEnchantDao::fetchEnchantInformation($permanentEnchantNumber);
		    $spellNumber = $enchantInfos[1];
		    $itemNumber = $enchantInfos[2];
		    if(!empty($spellNumber) && $spellNumber <> 0){
			    $result = $this->buildSpellURL($spellNumber);
		    }
		    if(!empty($itemNumber) && $itemNumber <> 0){
			    $result = $this->buildItemURL($itemNumber);
		    }
		}
    	return $result;
    }
 
}

?>
