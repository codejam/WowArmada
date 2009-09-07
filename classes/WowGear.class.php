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
 * WowGear Class
 *
 * The WowGear class aggregates all WowBaseItem related to the character gear.
 * The class includes the Gem and Enchant information on the gear as with additional informations
 * on the gear (level, name, etc).
 *
 * Copyright (C) <2009>  <codejam>
 */

require_once ( dirname( __FILE__ ) . '/WowGearSummary.class.php');
require_once ( dirname( __FILE__ ) . '/WowBaseItem.class.php');
require_once ( dirname( __FILE__ ) . '/XmlHelper.class.php');
require_once ( dirname( __FILE__ ) . '/WowPermanentEnchantDao.class.php');
 
class WowGear extends WowGearSummary {

    /**
     * The item information on this gear
     * @var WowBaseItem gearItem
     */
    protected $gearItem = NULL;
    
    /**
     * The item information on this gear
     * @var string gearItemXML nodes
     */
    protected $gearItemXML = NULL;
    
    /**
     * The item information on the gear's enchant
     * @var WowBaseItem gearEnchant
     */
    protected $gearEnchant = NULL;

    /**
     * The item information on the gear's enchant
     * @var string gearEnchantXML nodes
     */
    private $gearEnchantXML = NULL;
    
    /**
     * The item information on the gear's first gem
     * @var WowBaseItem gearFirstGem
     */
    protected $gearFirstGem = NULL;

    /**
     * The item information on the gear's first gem
     * @var string gearFirstGemXML nodes
     */
    private $gearFirstGemXML = NULL;
    
    /**
     * The item information on the gear's second gem
     * @var WowBaseItem gearSecondGem
     */
    protected $gearSecondGem = NULL;

    /**
     * The item information on the gear's second gem
     * @var string gearSecondGemXML nodes
     */
    private $gearSecondGemXML = NULL;

        
    /**
     * The item information on the gear's third gem
     * @var WowBaseItem gearThirdGem
     */
    protected $gearThirdGem = NULL;
    
    /**
     * The item information on the gear's third gem
     * @var string gearThirdGemXML nodes
     */
    private $gearThirdGemXML = NULL;

    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param string globalXmlData, the XML data containing all detail item information
     * @param int slotNumber, the gear slot number
     */
    public function __construct($gearSummaryXML, $baseItemXML, $enchantXML = NULL, $gem0XML = NULL, $gem1XML = NULL, $gem2XML = NULL){
	    // init of the WowGearSummary parent
	    parent::__construct($gearSummaryXML);
	    
	    // init of all gear components
	    $this->gearItem = new WowBaseItem($baseItemXML);
	    $this->gearItemXML = $baseItemXML;
	    
	    if(!empty($enchantXML)){
	    	$this->gearEnchant = new WowBaseItem($enchantXML);
	    	$this->gearEnchantXML = $echantXML;
    	}
    	if(!empty($gem0XML)){
	    	$this->gearFirstGem = new WowBaseItem($gem0XML);
	    	$this->gearFirstGemXML = $gem0XML;
    	}
    	if(!empty($gem1XML)){
	    	$this->gearSecondGem = new WowBaseItem($gem1XML);
	    	$this->gearSecondGemXML = $gem1XML;
    	}
    	if(!empty($gem2XML)){
	    	$this->gearThirdGem = new WowBaseItem($gem2XML);
	    	$this->gearThirdGemXML = $gem2XML;
    	}
    }

    /**
     * The toString() function
     * @return The WowGearSummary as XML
     */
    public function __toString()
    {
        return WowGearSummary::__toString();
    }
    
    /**
     * The following accessor functions should ease access to information
     */
	
    public function getIcon()			{ return (string) $this->gearItem->getIcon(); }
    public function getId()				{ return (string) $this->gearItem->getId(); }
    public function getLevel()			{ return (string) $this->gearItem->getLevel(); }
    public function getName()			{ return (string) $this->gearItem->getName(); }
    public function getQuality()		{ return (string) $this->gearItem->getQuality(); }
    public function getItemType()		{ return (string) $this->gearItem->getItemType(); }
    
    public function getFirstGem() {
	    $result = NULL;
	    $gem0Id = $this->getGem0Id();
		if(!empty($gem0Id)){
			$result = $this->gearFirstGem;
		}
	    return $result;
	}
	
    public function getSecondGem() {
	    $result = NULL;
	    $gem1Id = $this->getGem1Id();
		if(!empty($gem1Id)){
			$result = $this->gearSecondGem;
		}
	    return $result;
	}
	
    public function getThirdGem() {
	    $result = NULL;
	    $gem2Id = $this->getGem2Id();
	    if(!empty($gem2Id)){
   			$result = $this->gearThirdGem;
		}
	    return $result;
    }
    
    public function getEnchant() {
	    $result = NULL;
	    $enchantId = $this->getEnchantNumber();
	    if(!empty($enchantId)){
   			$result = $this->gearEnchant;
		}
	    return $result;
    }
    
}

?>
