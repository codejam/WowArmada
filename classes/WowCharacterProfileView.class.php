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
 * WowCharacterProfileView Class
 *
 * This class represent a dispaly of a WowCharacterProfile object (model). The class uses other
 * adapter to generate HTML elements (WowHead links for example).
 * 
 * Most of this class functions do not takes parameters. Even if it seems longer programming,
 * its too ease the template creation. For most of the functions, a copy-paste procedure and a
 * search-replace have done the job. Even if you are tempted to reduce the number of functions,
 * and introduce some fancy parameters or introspections, keep in mind that this class have
 * been programmed like that by someone who know how to do this with less functions. 
 * It is a choice, not a lack of programming skills.
 *
 * I have mapped every information to a function which allow the print out of all available
 * information easily. Check the raw template. 
 *
 * @see WowCharacterProfile
 * @see WowItemDBAdapter
 * @see WowArmoryAdapter
 *
 * Copyright (C) <2009>  <codejam>
 */
 
require_once ( dirname( __FILE__ ) . '/WowCharacterProfile.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowItemDBAdapter.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowArmoryAdapter.class.php');
 
class WowCharacterProfileView {

    /**
     * The character object
     * @var WowCharacterProfile characterObject
     */
    public $characterObject = NULL;
    
    /**
     * The armory url used to build links in the view
     * @var WowArmoryAdapter armoryAdapter
     */
    protected $armoryAdapter = NULL;
    
    /**
	 * The item database site adapter class to build links
     * @var WowItemDBAdapter itemDBAdapter
     */
    public $itemDBAdapter = NULL;	
    
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param WowCharacterProfile aWowCharObj, the wow character object
     * @param ArmoryAdapter anArmoryAdapter, the armory adapter used to build links
     * @param itemDBAdapter anitemDBAdapter, the item database adapter object
     */
    public function __construct($aWowCharObj, $anArmoryAdapter, $anItemDBAdapter){
		$this->characterObject = $aWowCharObj;
		$this->armoryAdapter = $anArmoryAdapter;
		$this->itemDBAdapter = $anItemDBAdapter;
    }
    
    /**
     * This function returns the HTML code for the provided template name
     * @param template, string, the template name (will match the directory and php file name)
     * @return string, the HTML code for the provided template name
     */    
    public function getWowCharacterProfileAsHTML($wapTemplate){
	    $result = '';
	    if(!empty($this->characterObject)) {
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
    public function getWowCharacterProfileViewCSSElement($aBasedUrl, $waaTemplate){
	    $result = '<link rel="stylesheet" type="text/css" href="' . $aBasedUrl . '/templates/' . $waaTemplate . '/' . $waaTemplate . '.css">';
	    return $result;
    }    

    /**
     * Gets the character avatar url on the armory
     * @return string avatarURL, the armory url to the character avatar
     */
    public function getAvatarURL(){
		return $this->buildCharacterAvatarURL($this->armoryAdapter->getWowArmoryUrl(),
											$this->characterObject->getLevel(),
											$this->characterObject->getGenderId(),
											$this->characterObject->getRaceId(),
											$this->characterObject->getWowClassId());
    }
     
    /**
     * Gets the character main talent icon url
     * @return string, the armory url to the character talent icon
     */
    public function getMainTalentIconURL(){
		return $this->buildTalentIconURL($this->armoryAdapter->getWowArmoryUrl(),
										$this->characterObject->getWowClassId(),
										$this->characterObject->getMainTalentBranch());
    }

    /**
     * Gets the character alt talent icon url
     * @return string, the armory url to the character talent icon
     */
    public function getAltTalentIconURL(){
		return $this->buildTalentIconURL($this->armoryAdapter->getWowArmoryUrl(),
										$this->characterObject->getWowClassId(),
										$this->characterObject->getAltTalentBranch());
    }
        
    /**
     * Gets the character talent icon url
     * @return string, the armory url to the character talent icon
     */
    public function getFirstProfessionIconURL(){
		return $this->buildProfessionIconURL($this->armoryAdapter->getWowArmoryUrl(),
											strtolower($this->characterObject->getFirstProfession()));
    }
    
    /**
     * Gets the character talent icon url
     * @return string, the armory url to the character talent icon
     */
    public function getSecondProfessionIconURL(){
		return $this->buildProfessionIconURL($this->armoryAdapter->getWowArmoryUrl(),
											strtolower($this->characterObject->getSecondProfession()));
    }
    
    /**
     * Gets Icons for all items
     * @return string, the armory url to the item icons
     */
    public function getGearSmallIconURL($wowGearSummary)	{ return $this->buildItemSmallIconURL($this->armoryAdapter->getWowArmoryUrl(), $wowGearSummary->getIcon()); }
    public function getGearMediumIconURL($wowGearSummary)	{ return $this->buildItemMediumIconURL($this->armoryAdapter->getWowArmoryUrl(), $wowGearSummary->getIcon()); }
    public function getGearBigIconURL($wowGearSummary)		{ return $this->buildItemBigIconURL($this->armoryAdapter->getWowArmoryUrl(), $wowGearSummary->getIcon()); }
    
 

	/**
	 * Gets item URL to item db site
	 * @return string, the item db site url to the item
	 */
	public function getGearItemDBURL($wowGearSummary)			{ return $this->itemDBAdapter->buildItemURL($wowGearSummary->getId()); }
	public function getGearGem0ItemDBURL($wowGearSummary)		{ return $this->itemDBAdapter->buildItemURL($wowGearSummary->getGem0Id()); }
	public function getGearGem1ItemDBURL($wowGearSummary)		{ return $this->itemDBAdapter->buildItemURL($wowGearSummary->getGem1Id()); }
	public function getGearGem2ItemDBURL($wowGearSummary)		{ return $this->itemDBAdapter->buildItemURL($wowGearSummary->getGem2Id()); }
	public function getGearEnchantName($wowGearSummary)			{ return WowPermanentEnchantDao::getPermanentEnchantName($wowGearSummary->getEnchantNumber()); }
	public function getGearEnchantItemDBURL($wowGearSummary)	{ return $this->itemDBAdapter->buildPermanentEnchantURL($wowGearSummary->getEnchantNumber()); }

		
    /**
    * This function returns the link tag <a> for the gear enchant
    * @return string, the html link tag
    */
	public function getGearEnchantLink($wowGearSummary) {
		$result = '';
		$enchantNumber = $wowGearSummary->getEnchantNumber();
		if(!empty($enchantNumber) && ($enchantNumber <> 0)){
			$result = "<a href='" . $this->getGearEnchantItemDBURL($wowGearSummary) . "'>" . $this->getGearEnchantName($wowGearSummary) . "</a>";
		} 
		return $result;
	}

    /**
    * This function returns the link tag <a> for the gear gem 0
    * @return string, the html link tag
    */
	public function getGearGem0Link($wowGearSummary) {
		$result = '';
		$gemId = $wowGearSummary->getGem0Id();
		if(!empty($gemId) && ($gemId <> 0)){
			$result = "<a href='" . $this->getGearGem0ItemDBURL($wowGearSummary) . "'>" . "Gem 0" . "</a>";
		} 
		return $result;
	}

    /**
    * This function returns the link tag <a> for the gear gem 1
    * @return string, the html link tag
    */
	public function getGearGem1Link($wowGearSummary) {
		$result = '';
		$gemId = $wowGearSummary->getGem1Id();
		if(!empty($gemId) && ($gemId <> 0)){
			$result = "<a href='" . $this->getGearGem1ItemDBURL($wowGearSummary) . "'>" . "Gem 1" . "</a>";
		} 
		return $result;
	}

    /**
    * This function returns the link tag <a> for the gear gem 2
    * @return string, the html link tag
    */
	public function getGearGem2Link($wowGearSummary) {
		$result = '';
		$gemId = $wowGearSummary->getGem2Id();
		if(!empty($gemId) && ($gemId <> 0)){
			$result = "<a href='" . $this->getGearGem2ItemDBURL($wowGearSummary) . "'>" . "Gem 2" . "</a>";
		} 
		return $result;
	}


		
    /**
    * This function returns the url of a portrait icon for a
    * character from the Armory.
    *
    * ex.: http://www.wowarmory.com/_images/portraits/wow-80/0-4-11.gif
    * @param string $armoryAdapter->getArmoryUrl(), the armory url used as based url
    * @param int $level, the character level number
    * @param int $genderId, the character gender id number
    * @param int $raceId, the character race id number
    * @param int $classId, the character class id number
    * @return string, The Avatar URL
    */
    protected function buildCharacterAvatarURL($armoryUrl, $level, $genderId, $raceId, $classId) {
	    $result = '';
	    if(!empty($level) && !empty($genderId) && !empty($raceId) && !empty($classId)){
	        $dir = "wow" . ($level < 70 ? "-default" : ($level < 80 ? "-70" : "-80"));
	        $result = $armoryUrl . "/_images/portraits/$dir/$genderId-$raceId-$classId.gif";
    	}
    	return $result;
    }
    
   /**
    * This function returns the url of a talent icon for a
    * character from the Armory.
    * 
    * ex.: http://www.wowarmory.com/_images/icons/class/11/talents/1.gif
    * @param string $armoryAdapter->getArmoryUrl(), the armory url used as based url
    * @param int $classId, the character class id number
    * @param int $mainSpec, the branch number of this highest talent branch
    * @return string, The talent icon URL
    */
    protected function buildTalentIconURL($armoryUrl, $classId, $mainSpec) {
	    $result = '';
	    if(!empty($classId) && ($mainSpec < 4) ){
		    if($mainSpec <> 0){
			    $result = $armoryUrl .  "/_images/icons/class/$classId/talents/$mainSpec.gif";
		    } else {
				$result = $armoryUrl .  "/_images/icons/class/talents/untalented.gif";
			}
		}
    	return $result;
    }
    
   /**
    * This function returns the url of a profession icon for a
    * character from the Armory.
    * 
    * ex.: http://www.wowarmory.com/_images/icons/professions/alchemy-sm.gif
    * @param string $armoryAdapter->getArmoryUrl(), the armory url used as based url
    * @param string $profession, the profession name ALL LOWER CASE
    * @return string, The profession icon URL
    */
    protected function buildProfessionIconURL($armoryUrl, $profession) {
	    $result = '';
	    if(!empty($profession)){
			$result = $armoryUrl .  "/_images/icons/professions/$profession-sm.gif";
		}
    	return $result;
    }
    
   /**
    * This function returns the url of a small (43x43) item icon.
    * 
    * ex.: http://www.wowarmory.com/wow-icons/_images/43x43/inv_helmet_108.png
    * @param string $armoryUrl, the armory url used as based url
    * @param string $iconName, the icon name provided by the armory
    * @return string, The small icon URL
    */
    protected function buildItemSmallIconURL($armoryUrl, $iconName) {
	    $result = '';
	    if(!empty($iconName)){
			$result = $armoryUrl .  "/wow-icons/_images/43x43/$iconName.png";
		}
    	return $result;
    }
    
   /**
    * This function returns the url of a medium (51x51) item icon.
    * 
    * ex.: http://www.wowarmory.com/wow-icons/_images/51x51/inv_helmet_108.jpg
    * @param string $armoryUrl, the armory url used as based url
    * @param string $iconName, the icon name provided by the armory
    * @return string, The medium icon URL
    */
    protected function buildItemMediumIconURL($armoryUrl, $iconName) {
	    $result = '';
	    if(!empty($iconName)){
			$result = $armoryUrl .  "/wow-icons/_images/51x51/$iconName.jpg";
		}
    	return $result;
    }
    
   /**
    * This function returns the url of a big (64x64) item icon.
    * 
    * ex.: http://www.wowarmory.com/wow-icons/_images/64x64/inv_helmet_108.jpg
    * @param string $armoryUrl, the armory url used as based url
    * @param string $iconName, the icon name provided by the armory
    * @return string, The big icon URL
    */
    protected function buildItemBigIconURL($armoryUrl, $iconName) {
	    $result = '';
	    if(!empty($iconName)){
			$result = $armoryUrl .  "/wow-icons/_images/64x64/$iconName.jpg";
		}
    	return $result;
    }
    
}

?>    