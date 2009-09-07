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
 * WowArmoryAdapter Class
 *
 * A class library to fetch and serialize XML data from the World of Warcraft Armory website.
 *
 * This class is a wrapper around the remarkable phpArmory class:
 *-----------------------------------------------------------------------------------------------
 * phpArmory is an embeddable PHP5 class, which allow you to fetch XML data
 * from the World of Warcraft armory in order to display arena teams,
 * characters, guilds, and items on a web page.
 * @author Daniel S. Reichenbach <daniel.s.reichenbach@mac.com>
 * @copyright Copyright (c) 2008, Daniel S. Reichenbach
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * @link https://github.com/marenkay/phparmory/tree
 * @package phpArmory
 * @version 0.4.2
 *-----------------------------------------------------------------------------------------------
 *
 * Copyright (C) <2009>  <codejam>
 */

require_once ( dirname( __FILE__ ) . '/WowArmadaExceptionHandler.class.php');
require_once ( dirname( __FILE__ ) . '/WowArmadaException.class.php');
require_once ( dirname( __FILE__ ) . '/WowPermanentEnchantDao.class.php');
require_once ( dirname( __FILE__ ) . '/phpArmory.class.php');
 
class WowArmoryAdapter extends phpArmory5 {

    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param string areaName, the area name where to retreive armory information
     */
    public function __construct($areaName){
	    parent::__construct($areaName);
    }

   /*
    * Returns the server url used to fetch information.
    * @return string, the item database server url
    */
    public function getWowArmoryUrl(){
	    $result = "http://www.wowarmory.com/";
	    // area is an array : [AREA_NAME, ARMORY_URL, WORLD_OF_WARCRAFT_URL]
        $areaArray = $this->getArea();
        if(is_array($areaArray) && !empty($areaArray[1])){
	        $result = $areaArray[1];
        } else {
	        WowArmadaExceptionHandler::triggerWarning("phpArmory area is not initialized properly. Returning default armory url.");
        }
        return $result;
    }
    
    /**
    * This function returns an WowCharacter object for a character in the Armory.
    * The function retrieves the following xml pages:
    * - character-sheet
    * - character-reputation
    * - character-talents
    * - character achievements
    * - character-statistics
    * Instead of using an XML to array conversion, the function uses XML manipulations.
    * This should help to adapt the code to armory modifications.
    * For performance considerations, you could cached the XML that is available in the WowCharacter class.
    * (You can use the saveXML function on the XML object to get a serialized version - XML)
    *
    * @param string character, The name of the character (mandatory, case sensitive)
    * @param string realm, The character's realm (mandatory, case sensitive)
    * @return string, all character information as XML or empty string
    */
    public function fetchCharacterProfile($character, $realm){
	    $result = '';
        if(!empty($character) && !empty($realm)){
		    // building the url extected by the armory
		    $url = $this->getWowArmoryUrl() . "/character-%s.xml?r=".str_replace(" ", "+",$realm)."&n=".str_replace(" ", "+",$character);
		    
			$characterInfo = new DOMDocument();

			// The following 2 pages (tabs) contains similar XML structure (inside character info)
		    // getting armory information for the character: sheet
			$sheetNode = $this->fetchAndCreateXmlNode(sprintf($url, 'sheet'), 'characterInfo');
			$sheetNode = $characterInfo->importNode($sheetNode, true);
			$characterInfo->appendChild($sheetNode);
			
		    // getting armory information for the character: talents
			$talentNode = $this->fetchAndCreateXmlNode(sprintf($url, 'talents'), 'talents');
			$talentNode = $characterInfo->importNode($talentNode, true);
			$characterInfo->firstChild->appendChild($talentNode);

		    // getting armory information for the character: reputation
			$reputationNode = $this->fetchAndCreateXmlNode(sprintf($url, 'reputation'), 'reputationTab');
			$reputationNode = $characterInfo->importNode($reputationNode, true);
			$characterInfo->firstChild->appendChild($reputationNode);

			
		    // getting armory information for the character: achievements
			$achievementsNode = $this->fetchAndCreateXmlNode(sprintf($url, 'achievements'), 'achievements');
			$achievementsNode = $characterInfo->importNode($achievementsNode, true);
			$characterInfo->firstChild->appendChild($achievementsNode);
		    
		    // getting armory information for the character: statistics
			$statisticsNode = $this->fetchAndCreateXmlNode(sprintf($url, 'statistics'), 'statistics');
			$statisticsNode = $characterInfo->importNode($statisticsNode, true);
			$characterInfo->firstChild->appendChild($statisticsNode);
			
			$result = $characterInfo->saveXML();
		}
		return $result;
    }
    
    public function fetchCharacterGear($aWowGearSummary) {
	    $result = '';
        if($aWowGearSummary instanceof WowGearSummary){
		    // building the url extected by the armory
		    $url = $this->getWowArmoryUrl() . "/item-info.xml?i=%s";
		    
			$gearInfo = new DOMDocument();

		    // getting armory information for the item general information
			$itemInfo = $this->fetchAndCreateXmlNode(sprintf($url, $aWowGearSummary->getId()), 'itemInfo');
			$itemInfo = $gearInfo->importNode($itemInfo, true);
			$gearInfo->appendChild($itemInfo);
			
		    // getting armory information for the item first gem
		    if($aWowGearSummary->getGem0Id() != 0){
				$gem0Info = $this->fetchAndCreateXmlNode(sprintf($url, $aWowGearSummary->getGem0Id()), 'item');
				$gem0Info = $gearInfo->importNode($gem0Info, true);
				$gearInfo->firstChild->appendChild($gem0Info);
			}

		    // getting armory information for the item second gem
		    if($aWowGearSummary->getGem1Id() != 0){
	   			$gem1Info = $this->fetchAndCreateXmlNode(sprintf($url, $aWowGearSummary->getGem1Id()), 'item');
				$gem1Info = $gearInfo->importNode($gem1Info, true);
				$gearInfo->firstChild->appendChild($gem1Info);
			}

		    // getting armory information for the item third gem
		    if($aWowGearSummary->getGem2Id() != 0){		    
				$gem2Info = $this->fetchAndCreateXmlNode(sprintf($url, $aWowGearSummary->getGem2Id()), 'item');
				$gem2Info = $gearInfo->importNode($gem2Info, true);
				$gearInfo->firstChild->appendChild($gem2Info);
			}

		    // getting armory information for the item permanent enchants
		    if($aWowGearSummary->getEnchantNumber() != 0){
				$enchantInfo = $this->fetchAndCreateXmlNode(sprintf($url, WowPermanentEnchantDao::getEnchantNumber($wowGearSummary->getEnchantNumber())), 'item');
				$enchantInfo = $gearInfo->importNode($enchantInfo, true);
				$gearInfo->firstChild->appendChild($enchantInfo);
			}

			$result = $gearInfo->saveXML();
		}
		return $result;
    }
    
    public function fetchItem($anItemNumber) {
	    $result = '';
	    if(($anItemNumber != NULL)
	    	&& ($anItemNumber != '0')
			&& ($anItemNumber != 0)
	    	&& ($anItemNumber != "")){
		    // building the url extected by the armory
		    $url = $this->getWowArmoryUrl() . "/item-info.xml?i=%s";
		    
			$xmlInfo = new DOMDocument();
		
		    // getting armory information for the item general information
			$itemInfo = $this->fetchAndCreateXmlNode(sprintf($url, $anItemNumber), 'itemInfo');
			$itemInfo = $xmlInfo->importNode($itemInfo, true);
			$xmlInfo->appendChild($itemInfo);
			
			$result = $xmlInfo->saveXML();
		}
		return $result;
    }
    
    /**
     * This function retreives an xml bloc from the provided url (armory).
     * @param string the url request for the xml bloc
     */
    private function fetchXmlInformationBloc($url){
	    $result = '';
		$fetchResult = $this->getXmlData($url);
		if(is_array($fetchResult) && ($fetchResult['result'] == TRUE)){
	    	$result = $fetchResult['XmlData'];
		} elseif (is_array($fetchResult) && ($fetchResult['result'] == FALSE)) {
	    	throw new WowArmadaException("phpArmory error message:" . $fetchResult['error']);
		}
	    return $result;
    }
    
    /**
     * This function retreives an xml bloc from the provided url (armory).
     * @param string the url request for the xml bloc
     * @param string the name of the node to return
     */
    private function fetchAndCreateXmlNode($url, $node){
	    $result = '';
    	$nodeXMLdoc = $this->fetchXmlInformationBloc($url);
    	if(!empty($nodeXMLdoc)){
			$nodeXMLobj = new DOMDocument();
			$nodeXMLobj->loadXML($nodeXMLdoc);
			$nodes = $nodeXMLobj->getElementsByTagName($node);
			if(!is_null($nodes) || $nodes->length > 1){
				$result = $nodes->item(0);
			} else {
				WowArmadaExceptionHandler::triggerError("Can't find '" . $node . "' in the xml result./n" . print_r(nodeXMLdoc));
			}
		} else {
			throw new WowArmadaException("Empty result from the armory.");
		}
	    return $result;
    }


}

?>
