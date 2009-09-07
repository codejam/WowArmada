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
 * WowBaseItem Class
 *
 * A class library that wrapped serialized XML data for items from the World of Warcraft Armory website.
 * This class represent the general item information provided by the world of warcraft armory.
 *
 * The armory provides a lot of information for items like the buying/selling cost, drop rate,
 * set information, quest reward, etc. These information are not defined here as they do not provide
 * relevent information for a character profile.
 *
 * If your usage of this class requires you to return that kind of specific information, you are encourage tu sublcass
 * this class as the armory returns different type of items with different data structure. Also, the information
 * defined here is common to all type of items.
 *
 * <item icon="inv_chest_plate02" id="39547" level="200" name="Heroes' Dreamwalker Vestments" quality="4" type="Leather">
 * </item>
 *
 * Copyright (C) <2009>  <codejam>
 */

class WowBaseItem {

    /**
     * The XML object containing armory information.
     * @var SimpleXMLElement charXMLObj
     */
    protected $itemXMLObj = NULL;
    
    /**
     * The XML object containing armory information.
     * @var string itemXML
     */
    private $itemXML = "";
    
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param string itemXMLObj, the single XML item element
     */
    public function __construct($anItemXML){
	    $this->itemXML = $anItemXML;
		$this->itemXMLObj = new SimpleXMLElement($this->itemXML);
    }
    
    /**
     * The toString() function
     * @return The WowGearSummary as XML
     */
    public function __toString()
    {
        return $this->itemXML;
    }
    
    /**
     * The following accessor functions should ease access to information
     */
    public function getIcon()			{ return (string)$this->itemXMLObj->item->attributes()->icon; }
    public function getId()				{ return (string)$this->itemXMLObj->item->attributes()->id; }
    public function getLevel()			{ return (string)$this->itemXMLObj->item->attributes()->level; }
    public function getName()			{ return (string)$this->itemXMLObj->item->attributes()->name; }
    public function getQuality()		{ return (string)$this->itemXMLObj->item->attributes()->quality; }
    public function getItemType()		{ return (string)$this->itemXMLObj->item->attributes()->type; }
    
}

?>
