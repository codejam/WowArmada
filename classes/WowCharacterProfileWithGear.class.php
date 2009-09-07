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
 * WowCharacterProfileWithGear Class
 *
 *
 * Copyright (C) <2009>  <codejam>
 */
 
require_once ( dirname( __FILE__ ) . '/XmlHelper.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowGearSummary.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowGear.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowCharacterProfile.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowBaseItem.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowArmadaExceptionHandler.class.php');
 
class WowCharacterProfileWithGear extends WowCharacterProfile{

    /**
     * The array (map) of character's gear
     * @var WowGear wowCharacterEquipment
     */
    protected $wowCharacterEquipment = NULL;
    
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param string charXMLDoc, the XML data for the character as returned from the WowArmoryAdapter
     */
    public function __construct($charXMLDoc){
  	    // init of the WowCharacterProfile parent
	    parent::__construct($charXMLDoc);
	    $this->wowCharacterEquipment = array();
    }
    
    /**
     * This function adds a gear in the gear equipement list
     * If a previous gear was already there for the same slot number,
     * the previous gear is replaced by the new one.
     * @param WowGear aWowGear the gear to be added
     */  
	public function addGear($aWowGear) {
		if(!empty($aWowGear)){
			$slotNum = $aWowGear->getSlot();
			$this->wowCharacterEquipment["'" . $slotNum . "'"] = $aWowGear;
		}
    }

    /**
     * This function returns a gear for the provided slot number
     * @param string gearSlotNumber the gear slot number as returned by the armory
     * @return WowGear, gear for the provided slot number
     */  
	private function getGear($gearSlotNumber) {
		$result = NULL;
		$aGear = $this->wowCharacterEquipment["'" . $gearSlotNumber . "'"];
		if(!empty($aGear)){
			$result = $aGear;
		} else {
			WowArmadaExceptionHandler::triggerWarning("No WowGear found for slot number: " . $gearSlotNumber);
		}
		return $result;
    }
        

    
    /**
     * Gets the XML information of this character as returned by the armory
     * @return string, the armory xml information
     */    
  /*  public function getArmoryRawXML(){
	    return $this->charXMLObj->asXML();
    }*/
    
    /**
     * The following accessor functions should ease access to information
     */
     
	public function getHead()		{ return $this->getGear('0'); }
	public function getNeck()		{ return $this->getGear('1'); }
	public function getShoulder()	{ return $this->getGear('2'); }
	public function getShirt()		{ return $this->getGear('3'); }
	public function getChest()		{ return $this->getGear('4'); }
	public function getBelt()		{ return $this->getGear('5'); }
	public function getPants()		{ return $this->getGear('6'); }
	public function getBoots()		{ return $this->getGear('7'); }
	public function getBracers()	{ return $this->getGear('8'); }
    public function getGauntlets()	{ return $this->getGear('9'); }
    public function getRing1()		{ return $this->getGear('10'); }
    public function getRing2()		{ return $this->getGear('11'); }
    public function getTrinket1()	{ return $this->getGear('12'); }
    public function getTrinket2()	{ return $this->getGear('13'); }
    public function getCape()		{ return $this->getGear('14'); }
    public function getMainHand()	{ return $this->getGear('15'); }
    public function getOffHand()	{ return $this->getGear('16'); }
    public function getExtra()		{ return $this->getGear('17'); }
    public function getTabard()		{ return $this->getGear('18'); }
    public function getAmmo()		{ return $this->getGear('-1'); }    

}

?>
