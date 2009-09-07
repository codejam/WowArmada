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
 * WowCharacterProfileWithGearView Class
 *
 * Copyright (C) <2009>  <codejam>
 */
 
require_once ( dirname( __FILE__ ) . '/WowCharacterProfile.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowCharacterProfileWithGear.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowGear.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowBaseItem.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowItemDBAdapter.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowArmoryAdapter.class.php');
require_once ( dirname( __FILE__ ) . '/WowPermanentEnchantDao.class.php');
require_once ( dirname( __FILE__ ) . '/WowArmadaExceptionHandler.class.php');
 
class WowCharacterProfileWithGearView extends WowCharacterProfileView {

    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param WowCharacterProfileWithGear aWowCharObj, the wow character with gears object
     * @param ArmoryAdapter anArmoryAdapter, the armory adapter used to build links
     * @param itemDBAdapter anitemDBAdapter, the item database adapter object
     */
    public function __construct($aWowCharObj, $anArmoryAdapter, $anItemDBAdapter){
	     // init of the WowCharacterProfileView parent
	    if($aWowCharObj instanceof WowCharacterProfileWithGear){
	    	parent::__construct($aWowCharObj, $anArmoryAdapter, $anItemDBAdapter);
    	} else {
	    	WowArmadaExceptionHandler::triggerError("The WowCharacterProfileWithGearView constructor expects the first argument of type WowCharacterProfileWithGear.");
    	}
    }
    
    /**
     * Gets Icons for all items
     * @return string, the armory url to the item icons
     */
    public function getGearSmallIconURL($wowGear)	{ return $this->buildItemSmallIconURL($this->armoryAdapter->getWowArmoryUrl(), $wowGear->getIcon()); }
    public function getGearMediumIconURL($wowGear)	{ return $this->buildItemMediumIconURL($this->armoryAdapter->getWowArmoryUrl(), $wowGear->getIcon()); }
    public function getGearBigIconURL($wowGear)		{ return $this->buildItemBigIconURL($this->armoryAdapter->getWowArmoryUrl(), $wowGear->getIcon()); }
    
 

	/**
	 * Gets item URL to item db site
	 * @return string, the item db site url to the item
	 */
	public function getGearItemDBURL($wowGear)			{ return $this->itemDBAdapter->buildItemURL($wowGear->getId()); }
	public function getGearGem0ItemDBURL($wowGear)		{ return $this->itemDBAdapter->buildItemURL($wowGear->getGem0Id()); }
	public function getGearGem1ItemDBURL($wowGear)		{ return $this->itemDBAdapter->buildItemURL($wowGear->getGem1Id()); }
	public function getGearGem2ItemDBURL($wowGear)		{ return $this->itemDBAdapter->buildItemURL($wowGear->getGem2Id()); }
	public function getGearEnchantName($wowGear)		{ return WowPermanentEnchantDao::getPermanentEnchantName($wowGear->getEnchantNumber()); }
	public function getGearEnchantItemDBURL($wowGear)	{ return $this->itemDBAdapter->buildPermanentEnchantURL($wowGear->getEnchantNumber()); }

		
    /**
    * This function returns the link tag <a> for the gear enchant
    * @return string, the html link tag
    */
	public function getGearEnchantLink($wowGear) {
		$result = '';
		$itemEnchant = $wowGear->getEnchantItemId();
		$spellEnchant = $wowGear->getEnchantSpellId();
		if(!empty($itemEnchant)){
			$enchant = $wowGear->getEnchant();
			$result = "<a class='waa_quality_" . $enchant->getQuality() . "' href='" . $this->itemDBAdapter->buildItemURL($enchant->getId()) . "'>" . $this->getGearEnchantName($wowGear) . "</a>";			
		} elseif(!empty($spellEnchant)) {
			//armory won't give result for spell id
			$result = parent::getGearEnchantLink($wowGear);
		} else {
			$result = parent::getGearEnchantLink($wowGear);
		}
		return $result;
	}

    /**
    * This function returns the link tag <a> for the gear gem 0
    * @return string, the html link tag
    */
	public function getGearGem0Link($aWowGear) {
		$result = '';
		$firstGem = $aWowGear->getFirstGem();
		if($firstGem != NULL){
			$result = "<a class='waa_quality_" . $firstGem->getQuality() . "' href='" . $this->itemDBAdapter->buildItemURL($firstGem->getId()) . "'>" . $firstGem->getName() . "</a>";
		} 
		return $result;
	}

    /**
    * This function returns the link tag <a> for the gear gem 1
    * @return string, the html link tag
    */
	public function getGearGem1Link($aWowGear) {
		$result = '';
		$secondGem = $aWowGear->getSecondGem();
		if($secondGem != NULL){
			$result = "<a class='waa_quality_" . $secondGem->getQuality() . "' href='" . $this->itemDBAdapter->buildItemURL($secondGem->getId()) . "'>" . $secondGem->getName() . "</a>";
		} 
		return $result;
	}

    /**
    * This function returns the link tag <a> for the gear gem 2
    * @return string, the html link tag
    */
	public function getGearGem2Link($aWowGear) {
		$result = '';
		$thirdGem = $aWowGear->getThirdGem();
		if($thirdGem != NULL){
			$result = "<a class='waa_quality_" . $thirdGem->getQuality() . "' href='" . $this->itemDBAdapter->buildItemURL($thirdGem->getId()) . "'>" . $thirdGem->getName() . "</a>";
		} 
		return $result;
	}

}

?>    