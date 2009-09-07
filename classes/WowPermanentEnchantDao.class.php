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
 * WowPermanentEnchantDao Class
 *
 * Copyright (C) <2009>  <codejam>
 */
 
class WowPermanentEnchantDao {

  /**
    * This function returns the name of a permanent enchant
    *
    * Note that this function is intentionnaly not merged with the buildPermanentEnchantURL
    * function. That means that two read process are made to the "permanentenchant.xml" file.
    * This is fine because the goal is to i18n the name and use another source of information.
    * Therefore, those function needs to be separated.
    * ex.: Array ( [0] => +30 Spell Power and 20 Critical strike rating. [1] => 0 [2] => 44159 ) 
    * @see http://okoloth.blogspot.com/2008/12/armory-xml-permanentenchant-attribute.html
    * @param string $permanentEnchantNumber, the permanent enchant number provided by the armory
    * @return string, The name of the permanent enchant
    */
    public static function getPermanentEnchantName($permanentEnchantNumber) {
	    $result = '';
		if(!empty($permanentEnchantNumber)){
			$enchantInfos = WowPermanentEnchantDao::fetchEnchantInformation($permanentEnchantNumber);
			if (is_array($enchantInfos)) {
				$result = $enchantInfos[0];
			}
		}
	    return $result;
    }

  /**
    * This function returns the Spell id of a permanent enchant
    *
    * @param string $permanentEnchantNumber, the permanent enchant number provided by the armory
    * @return string, The spell of the permanent enchant
    */
    public static function getPermanentEnchantSpellId($permanentEnchantNumber) {
	    $result = '';
		if(!empty($permanentEnchantNumber)){
			$enchantInfos = WowPermanentEnchantDao::fetchEnchantInformation($permanentEnchantNumber);
			if (is_array($enchantInfos)) {
				$result = $enchantInfos[1];
			}
		}
	    return $result;
    }
    
  /**
    * This function returns the Item id of a permanent enchant
    *
    * @param string $permanentEnchantNumber, the permanent enchant number provided by the armory
    * @return string, The item id of the permanent enchant
    */
    public static function getPermanentEnchantItemId($permanentEnchantNumber) {
	    $result = '';
		if($permanentEnchantNumber != 0 && $permanentEnchantNumber != '0'){
			$enchantInfos = WowPermanentEnchantDao::fetchEnchantInformation($permanentEnchantNumber);
			if (is_array($enchantInfos)) {
				$result = $enchantInfos[2];
			}
		}
	    return $result;
    }
    
   /**
    * This function returns the Item or spell id of a permanent enchant
    *
    * @param string $permanentEnchantNumber, the permanent enchant number provided by the armory
    * @return string, The item id of the permanent enchant
    */
    public static function getPermanentEnchantId($permanentEnchantNumber) {
	    $result = 0;
		if($permanentEnchantNumber != 0 && $permanentEnchantNumber != '0'){
			$enchantInfos = WowPermanentEnchantDao::fetchEnchantInformation($permanentEnchantNumber);
			if (is_array($enchantInfos)) {
				if(!empty($enchantInfos[1])){
					$result = $enchantInfos[1];	
				} elseif(!empty($enchantInfos[2])) {
					$result = $enchantInfos[2];	
				}
			}
		}
	    return $result;
    }
    
   /**
    * This function returns an array made of three values:
    * { name, spellNumber, itemNumber }
    * The second value is the wowhead spell number for the provided
    * permanent enchant number and the third value is the item number
    * for the provided permanent enchant number.
    * Note that only one of the last two values will be set to a number <> 0
    *
    * ex.: Array ( [0] => +30 Spell Power and 20 Critical strike rating. [1] => 0 [2] => 44159 ) 
    * @see http://okoloth.blogspot.com/2008/12/armory-xml-permanentenchant-attribute.html
	*
    * @TODO: i18n in the data file
    * @see permanentenchant.xml
    * @param string $permanentEnchantNumber, the permanent enchant number provided by the armory
    * @return array, three values, the name, the item number and the spell number
    */
    public static function fetchEnchantInformation($permanentEnchantNumber) {
	    $result = '';
		if($permanentEnchantNumber != 0 && $permanentEnchantNumber != '0'){
			// we will use DOM to merge character tab information
			
			$upperPath = dirname(dirname( __FILE__ ));
			$permanentEnchantFile = $upperPath . '/data/' . PERMANENT_ENCHANT_XML;
			
			if (file_exists($permanentEnchantFile)) {
				$handle = fopen($permanentEnchantFile, "r");
				$permEnchantXMLdoc = fread($handle, filesize($permanentEnchantFile));
				$permanentEnchantsDOM = new DOMDocument();
				$permanentEnchantsDOM->loadXML($permEnchantXMLdoc);
				$xpath = new DOMXPath($permanentEnchantsDOM);
				$query = "//permanentenchants/permanentenchant[@id='$permanentEnchantNumber']";
				$entries = $xpath->query($query);
				if (!is_null($entries)){
					foreach ($entries as $foundElement){
						// should only get here once
				    	$result = array($foundElement->getAttribute('name'),
				    					$foundElement->getAttribute('spellId'),
				    					$foundElement->getAttribute('itemId') );
					}
				}
			}
			 else {
				echo "The file $filename does not exist";
			}
	    }
	    return $result;
    }
    	
}

?>
