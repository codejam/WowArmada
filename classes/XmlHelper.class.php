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
 * WowCharacterProfile Class
 *
 * A class library that wrapped serialized XML data from the World of Warcraft Armory website.
 * The expected XML structure does not match exactly the wow armory information, it is a 
 * mashup of all pages available for a character in the armory. The WowArmoryAdapter class will
 * provide the adequate structure expected by this class.
 *
 * Most of this class functions do not takes parameters. Even if it seems longer programming,
 * its too ease the template creation. For most of the functions, a copy-paste procedure and a
 * search-replace have done the job. Even if you are tempted to reduce the number of functions,
 * and introduce some parameters or fancy introspections, keep in mind that this class have
 * been programmed like that by someone who know how to do this with less functions. 
 * It is a choice, not a lack of programming skills. 
 *
 * I could have transformed the XML into an array, but that would have implied that the template
 * creator knows all available information. Instead, I have mapped every information to a function
 * which allow the print out of all available information easily. (check the raw template).
 * Furthermore, when the Armory will change its XML structure (it will), the templates will not be affected.
 *
 * @see WowArmoryAdapter::fetchCharacterProfile($character, $realm)
 *
 * Copyright (C) <2009>  <codejam>
 */
 
class XmlHelper {

	/**
     * This function makes an XPath search on the provided base SimpleXMLElement tree
     * to find one element. If the element is not found, an empty string will be returned.
     * @param SimpleXMLElement aBaseSimpleXMLElement, the base node in which the search will be performed
     * @param string anXPathToElement, the xpath search string (should identify one unique element)
     * @return SimpleXmlElement, the xml elment or an empty string if no element is found.
     */	
	public static function findOneElement($aBaseSimpleXMLElement, $anXPathToElement){
		$result = '';
		if(!empty($aBaseSimpleXMLElement) && !empty($anXPathToElement)){
			$arrayOfElement = $aBaseSimpleXMLElement->xpath($anXPathToElement);
			if(is_array($arrayOfElement) && !empty($arrayOfElement)){
				$firstElement = current($arrayOfElement);
				$result = $firstElement;
			}
		}
		return $result;
	}
	
	/**
     * This function makes an XPath search on the provided base SimpleXMLElement tree
     * to find one element. Then, it returns the value of the required attribute.
     * If the element is not found, an empty string will be returned.
     * @param SimpleXMLElement aBaseSimpleXMLElement, the base node in which the search will be performed
     * @param string anXPathToElement, the xpath search string (should identify one unique element)
     * @param string anAttributeToFind: the attribute used to return the value
     * @return string, the attribute value or an empty string if no element is found.
     */	
	public static function findValueForOneElement($aBaseSimpleXMLElement, $anXPathToElement, $anAttributeToFind){
		$result = '';
		if(!empty($anAttributeToFind)){
			$foundElement =	XmlHelper::findOneElement($aBaseSimpleXMLElement, $anXPathToElement);;
			if(!empty($foundElement)){
			    $attributes = $foundElement->attributes();
			    $result = $attributes[$anAttributeToFind];
		    }
		}
		return $result;
	}
	
    /**
     * This function makes an XPath search on the provided base SimpleXMLElement tree
     * to find many elements. Then, it returns the values found for the required attribute.
     * If no elements is found, an empty array will be returned.
     * @param SimpleXMLElement aBaseSimpleXMLElement, the base node in which the search will be performed
     * @param string anXPathToElement, the xpath search string (should identify one or more elements)
     * @param string anAttributeToFind: the attribute used to return the value
     * @return array, the attribute values or an empty array if no element are found.
     */	
	public static function findValueForManyElements($aBaseSimpleXMLElement, $anXPathToElement, $anAttributeToFind){
		$result = array();
		if(!empty($aBaseSimpleXMLElement) && !empty($anXPathToElement) && !empty($anAttributeToFind)){
			$arrayOfElement = $aBaseSimpleXMLElement->xpath($anXPathToElement);
			if(is_array($arrayOfElement) && !empty($arrayOfElement)){
				foreach ($arrayOfElement as $foundElement) {
				    $attributes = $foundElement->attributes();
				    array_push($result, $attributes[$anAttributeToFind]);
				}
			}
		}
		return $result;
	}

	
}

?>
