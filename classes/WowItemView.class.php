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
 * WowItemView Class
 *
 * This class represent a view of a WowItem object. It is based on one of the template availabe
 * and should provide all functions required by the template to represent the desired view object.
 *
 * @see WowItem
 *
 * Copyright (C) <2009>  <codejam>
 */
 
require_once ( dirname( __FILE__ ) . '/WowItem.class.php'); 
 
class WowItemView {

    /**
     * The item object
     * @var WowBaseItem itemObject
     */
    public $itemObject = NULL;
    
    /**
     * The armory url used to build links in the view
     * @var WowArmoryAdapter armoryAdapter
     */
    private $armoryAdapter = NULL;
    
    /**
	 * The item database site adapter class to build links
     * @var WowItemDBAdapter itemDBAdapter
     */
    public $itemDBAdapter = NULL;	
    
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param WowBaseItem aWowItemObj, the wow base item object
     * @param ArmoryAdapter anArmoryAdapter, the armory adapter used to build links
     * @param itemDBAdapter anitemDBAdapter, the item database adapter object
     */
    public function __construct($aWowItemObj, $anArmoryAdapter, $anItemDBAdapter){
		$this->itemObject = $aWowItemObj;
		$this->armoryAdapter = $anArmoryAdapter;
		$this->itemDBAdapter = $anItemDBAdapter;
    }
    
    /**
     * This function returns the HTML code for the provided template name
     * @param template, string, the template name (will match the directory and php file name)
     * @return string, the HTML code for the provided template name
     */    
    public function getWowItemAsHTML($wapTemplate){
	    $result = '';
	    if(!empty($this->itemObject)) {
		    $templatePath = dirname(dirname( __FILE__ ));
    		ob_start ();
    		require_once($templatePath . '/templates/' . $wapTemplate . '/' . $wapTemplate . '.php');
			$result = ob_get_contents ();
			ob_end_clean ();
	    }
	    return $result;
    }
    
   
    /**
     * This function returns the HTML code to include the proper CSS in your page
     * based on the template used for the view.
     * @param string aBasedUrl, the based url used to access the css file (the parent of the 'templates' folder
     * @param waaTemplate, string, the template name (will match the directory and css file name)
     * @return string, the HTML Link tag to include the required template
     */    
    public function getWowItemViewCSSElement($aBasedUrl, $waaTemplate){
	    $result = '<link rel="stylesheet" type="text/css" href="' . $aBasedUrl . '/templates/' . $waaTemplate . '/' . $waaTemplate . '.css">';
	    return $result;
    }     

}

?>
