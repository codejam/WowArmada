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
 * WowGearSummary Class
 *
 * A class library that wrapped serialized XML data for items from the World of Warcraft Armory website.
 * This item is defined with the information provided in the character information. It contains mostly
 * identifiations numbers that may be used to retrieve more detail information.
 *
 * <item durability="70" gem0Id="41333" gem1Id="40047" gem2Id="0" icon="inv_helmet_108" id="39240" maxDurability="70" permanentenchant="3820" randomPropertiesId="0" seed="0" slot="0"/>
 *
 * Copyright (C) <2009>  <codejam>
 */

require_once ( dirname( __FILE__ ) . '/WowPermanentEnchantDao.class.php');
 
class WowGearSummary {

    /**
     * The Gear Item Summary
     * @var SimpleXMLElement gearSummary
     */
    protected $gearSummary = NULL;
    
    /**
     * The Gear Item Summary XML
     * @var XML gearSummaryXML
     */
    private $gearSummaryXML = "";
    
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param string itemXMLstr, the XML data for the item as identified by the WowCharacterProfile class
     */
    public function __construct($itemXMLstr){
	    $this->gearSummaryXML = $itemXMLstr;
		$this->gearSummary = new SimpleXMLElement($this->gearSummaryXML);
    }
    

    /**
     * The toString() function
     * @return The WowGearSummary as XML
     */
    public function __toString()
    {
        return $this->gearSummaryXML;
    }
    
    /**
     * The following accessor functions should ease access to information
     */
    public function getDurability()			{ return $this->gearSummary->attributes()->durability; }
    public function getGem0Id()				{ return $this->gearSummary->attributes()->gem0Id; }
    public function getGem1Id()				{ return $this->gearSummary->attributes()->gem1Id; }
    public function getGem2Id()				{ return $this->gearSummary->attributes()->gem2Id; }
    public function getIcon()				{ return $this->gearSummary->attributes()->icon; }
    public function getId()					{ return $this->gearSummary->attributes()->id; }
    public function getMaxDurability()		{ return $this->gearSummary->attributes()->maxDurability; }
    public function getEnchantNumber()		{ return $this->gearSummary->attributes()->permanentenchant; }
    public function getEnchantItemId()		{ return WowPermanentEnchantDao::getPermanentEnchantItemId($this->getEnchantNumber()); }
    public function getEnchantSpellId()		{ return WowPermanentEnchantDao::getPermanentEnchantSpellId($this->getEnchantNumber()); }
    public function getRandomPropertiesId()	{ return $this->gearSummary->attributes()->randomPropertiesId; }
    public function getSeed()				{ return $this->gearSummary->attributes()->seed; }
    public function getSlot()				{ return $this->gearSummary->attributes()->slot; }
    
}

?>
