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
 
require_once ( dirname( __FILE__ ) . '/XmlHelper.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowGearSummary.class.php'); 
require_once ( dirname( __FILE__ ) . '/WowPermanentEnchantDao.class.php');
 
class WowCharacterProfile {

    /**
     * The XML object containing armory information.
     * @var SimpleXMLElement charXMLObj
     */
    protected $charXMLObj = NULL;
    
    /**
     * The WowGearSummary objects 
     * @var Array of WowGearSummary objects
     */
    public $wowGearSummaryMap = NULL;
    
    /**
     * The Constructor
     *
     * This function is called when the object is created.
     * @param string charXMLDoc, the XML data for the character as returned from the WowArmoryAdapter
     */
    public function __construct($charXMLDoc){
		$this->charXMLObj = new SimpleXMLElement($charXMLDoc);
		$this->wowGearSummaryMap = array();
    }
    
    /**
     * Gets the XML information of this character as returned by the armory
     * @return string, the armory xml information
     */    
    public function getArmoryRawXML(){
	    return $this->charXMLObj->asXML();
    }
    
    /**
     * The following accessor functions should ease access to information
     */
    public function getName()			{ return $this->charXMLObj->character->attributes()->name; }
    public function getLevel()			{ return $this->charXMLObj->character->attributes()->level; }
    public function getRace()			{ return $this->charXMLObj->character->attributes()->race; }
    public function getRaceId()			{ return $this->charXMLObj->character->attributes()->raceId; }
    public function getWowClass()		{ return $this->charXMLObj->character->attributes()->class; }
    public function getWowClassId()		{ return $this->charXMLObj->character->attributes()->classId; }
    public function getVersionDate()	{ return $this->charXMLObj->character->attributes()->lastModified; }
    public function getGuildName()		{ return $this->charXMLObj->character->attributes()->guildName; }
    public function getFaction()		{ return $this->charXMLObj->character->attributes()->faction; }
    public function getFactionId()		{ return $this->charXMLObj->character->attributes()->factionId; }
    public function getBattlegroup()	{ return $this->charXMLObj->character->attributes()->battleGroup; }
    public function getRealm()			{ return $this->charXMLObj->character->attributes()->realm; }
    public function getGender()			{ return $this->charXMLObj->character->attributes()->gender; }
    public function getGenderId()		{ return $this->charXMLObj->character->attributes()->genderId; }
    public function getAchievementPoints()	{ return $this->charXMLObj->character->attributes()->points; }
    
    public function getMainTalentBuild()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, '//talentGroups/talentGroup[@group="1"]/talentSpec', 'value'); }
    public function getMainTalentIcon()		{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="1"]', 'icon'); }
    public function getMainTalentPrim()		{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="1"]', 'prim'); }
    public function getMainTalentBranch1()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="1"]', 'treeOne'); }
    public function getMainTalentBranch2()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="1"]', 'treeTwo'); }
    public function getMainTalentBranch3()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="1"]', 'treeThree'); }

    
    public function getAltTalentBuild()		{ return XmlHelper::findValueForOneElement($this->charXMLObj, '//talentGroups/talentGroup[@group="2"]/talentSpec', 'value'); }
    public function getAltTalentIcon()		{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="2"]', 'icon'); }
    public function getAltTalentPrim()		{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="2"]', 'prim'); }
    public function getAltTalentBranch1()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="2"]', 'treeOne'); }
    public function getAltTalentBranch2()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="2"]', 'treeTwo'); }
    public function getAltTalentBranch3()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, '/characterInfo/characterTab/talentSpecs/talentSpec[@group="2"]', 'treeThree'); }

    
    public function getLifetimeHonorableKills()	{ return (string) $this->charXMLObj->characterTab->pvp->lifetimehonorablekills->attributes()->value; }
    public function getArenaCurrency() 			{ return (string) $this->charXMLObj->characterTab->pvp->arenacurrency->attributes()->value; }
    
    public function getFirstProfession() 		{ return XmlHelper::findValueForOneElement($this->charXMLObj, "/characterInfo/characterTab/professions/skill[1]", 'name'); } 
    public function getFirstProfessionMax()		{ return XmlHelper::findValueForOneElement($this->charXMLObj, "/characterInfo/characterTab/professions/skill[1]", 'max'); } 
    public function getFirstProfessionSkill()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, "/characterInfo/characterTab/professions/skill[1]", 'value'); } 
    
    public function getSecondProfession() 		{ return XmlHelper::findValueForOneElement($this->charXMLObj, "/characterInfo/characterTab/professions/skill[2]", 'name'); } 
    public function getSecondProfessionMax()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, "/characterInfo/characterTab/professions/skill[2]", 'max'); } 
    public function getSecondProfessionSkill()	{ return XmlHelper::findValueForOneElement($this->charXMLObj, "/characterInfo/characterTab/professions/skill[2]", 'value'); } 

    public function getTitle()		 	{ return XmlHelper::findValueForOneElement($this->charXMLObj, "/characterInfo/characterTab/title", 'value'); } 
    //TODO: Return Array of other titles
    
    public function getHealth()					{ return (string)$this->charXMLObj->characterTab->characterBars->health->attributes()->effective; }
    public function getSecondBarValue()			{ return (string)$this->charXMLObj->characterTab->characterBars->secondBar->attributes()->effective; }
    public function getSecondBarType()			{ return (string)$this->charXMLObj->characterTab->characterBars->secondBar->attributes()->type; }
    public function getSecondBarCasting()		{ return (string)$this->charXMLObj->characterTab->characterBars->secondBar->attributes()->casting; }
    public function getSecondBarNotCasting()	{ return (string)$this->charXMLObj->characterTab->characterBars->secondBar->attributes()->notCasting; }

    public function getStrengthBase()			{ return (string)$this->charXMLObj->characterTab->baseStats->strength->attributes()->base; }
    public function getStrengthAttack()			{ return (string)$this->charXMLObj->characterTab->baseStats->strength->attributes()->attack; }
    public function getStrengthBlock()			{ return (string)$this->charXMLObj->characterTab->baseStats->strength->attributes()->block; }
    public function getStrengthEffective()		{ return (string)$this->charXMLObj->characterTab->baseStats->strength->attributes()->effective; }

    public function getAgilityArmor()			{ return (string)$this->charXMLObj->characterTab->baseStats->agility->attributes()->armor; }
    public function getAgilityAttack()			{ return (string)$this->charXMLObj->characterTab->baseStats->agility->attributes()->attack; }
    public function getAgilityBase()			{ return (string)$this->charXMLObj->characterTab->baseStats->agility->attributes()->base; }
    public function getAgilityCritHitPercent()	{ return (string)$this->charXMLObj->characterTab->baseStats->agility->attributes()->critHitPercent; }
    public function getAgilityEffective()		{ return (string)$this->charXMLObj->characterTab->baseStats->agility->attributes()->effective; }
    
    public function getStaminaBase()			{ return (string)$this->charXMLObj->characterTab->baseStats->stamina->attributes()->base; }
	public function getStaminaEffective()		{ return (string)$this->charXMLObj->characterTab->baseStats->stamina->attributes()->effective; }    
    public function getStaminaHealth()			{ return (string)$this->charXMLObj->characterTab->baseStats->stamina->attributes()->health; }
    public function getStaminaPetBonus()		{ return (string)$this->charXMLObj->characterTab->baseStats->stamina->attributes()->petBonus; }

    public function getIntellectBase()			{ return (string)$this->charXMLObj->characterTab->baseStats->intellect->attributes()->base; }
	public function getIntellectCritHitPercent(){ return (string)$this->charXMLObj->characterTab->baseStats->intellect->attributes()->critHitPercent; }    
    public function getIntellectEffective()		{ return (string)$this->charXMLObj->characterTab->baseStats->intellect->attributes()->effective; }	
    public function getIntellectMana()			{ return (string)$this->charXMLObj->characterTab->baseStats->intellect->attributes()->mana; }
    public function getIntellectPetBonus()		{ return (string)$this->charXMLObj->characterTab->baseStats->intellect->attributes()->petBonus; }

    public function getSpiritBase()				{ return (string)$this->charXMLObj->characterTab->baseStats->spirit->attributes()->base; }
    public function getSpiritEffective()		{ return (string)$this->charXMLObj->characterTab->baseStats->spirit->attributes()->effective; }	
    public function getSpiritHealthRegen()		{ return (string)$this->charXMLObj->characterTab->baseStats->spirit->attributes()->healthRegen; }
    public function getSpiritManaRegen()		{ return (string)$this->charXMLObj->characterTab->baseStats->spirit->attributes()->manaRegen; }

    public function getArmorBase()				{ return (string)$this->charXMLObj->characterTab->baseStats->armor->attributes()->base; }
    public function getArmorEffective()			{ return (string)$this->charXMLObj->characterTab->baseStats->armor->attributes()->effective; }	
    public function getArmorPercent()			{ return (string)$this->charXMLObj->characterTab->baseStats->armor->attributes()->percent; }
    public function getArmorPetBonus()			{ return (string)$this->charXMLObj->characterTab->baseStats->armor->attributes()->petBonus; }

    public function getArcaneResistance()		{ return (string)$this->charXMLObj->characterTab->resistances->arcane->attributes()->value; }
    public function getArcaneResistanceForPet()	{ return (string)$this->charXMLObj->characterTab->resistances->arcane->attributes()->petBonus; }

    public function getFireResistance()			{ return (string)$this->charXMLObj->characterTab->resistances->fire->attributes()->value; }
    public function getFireResistanceForPet()	{ return (string)$this->charXMLObj->characterTab->resistances->fire->attributes()->petBonus; }

    public function getFrostResistance()		{ return (string)$this->charXMLObj->characterTab->resistances->frost->attributes()->value; }
    public function getFrostResistanceForPet()	{ return (string)$this->charXMLObj->characterTab->resistances->frost->attributes()->petBonus; }

    public function getHolyResistance()			{ return (string)$this->charXMLObj->characterTab->resistances->holy->attributes()->value; }
    public function getHolyResistanceForPet()	{ return (string)$this->charXMLObj->characterTab->resistances->holy->attributes()->petBonus; }

    public function getNatureResistance()		{ return (string)$this->charXMLObj->characterTab->resistances->nature->attributes()->value; }
    public function getNatureResistanceForPet()	{ return (string)$this->charXMLObj->characterTab->resistances->nature->attributes()->petBonus; }

    public function getShadowResistance()		{ return (string)$this->charXMLObj->characterTab->resistances->shadow->attributes()->value; }
    public function getShadowResistanceForPet()	{ return (string)$this->charXMLObj->characterTab->resistances->shadow->attributes()->petBonus; }

    public function getMeleeMainHandDamageDps()		{ return (string)$this->charXMLObj->characterTab->melee->mainHandDamage->attributes()->dps; }
    public function getMeleeMainHandDamageMax()		{ return (string)$this->charXMLObj->characterTab->melee->mainHandDamage->attributes()->max; }	
    public function getMeleeMainHandDamageMin()		{ return (string)$this->charXMLObj->characterTab->melee->mainHandDamage->attributes()->min; }
    public function getMeleeMainHandDamagePercent()	{ return (string)$this->charXMLObj->characterTab->melee->mainHandDamage->attributes()->percent; }
    public function getMeleeMainHandDamageSpeed()	{ return (string)$this->charXMLObj->characterTab->melee->mainHandDamage->attributes()->speed; }

    public function getMeleeOffHandDamageDps()		{ return (string)$this->charXMLObj->characterTab->melee->offHandDamage->attributes()->dps; }
    public function getMeleeOffHandDamageMax()		{ return (string)$this->charXMLObj->characterTab->melee->offHandDamage->attributes()->max; }	
    public function getMeleeOffHandDamageMin()		{ return (string)$this->charXMLObj->characterTab->melee->offHandDamage->attributes()->min; }
    public function getMeleeOffHandDamagePercent()	{ return (string)$this->charXMLObj->characterTab->melee->offHandDamage->attributes()->percent; }
    public function getMeleeOffHandDamageSpeed()	{ return (string)$this->charXMLObj->characterTab->melee->offHandDamage->attributes()->speed; }

    public function getMeleeMainHandSpeedHastePercent()		{ return (string)$this->charXMLObj->characterTab->melee->mainHandSpeed->attributes()->hastePercent; }
    public function getMeleeMainHandSpeedHasteRating()		{ return (string)$this->charXMLObj->characterTab->melee->mainHandSpeed->attributes()->hasteRating; }	
    public function getMeleeMainHandSpeedValue()			{ return (string)$this->charXMLObj->characterTab->melee->mainHandSpeed->attributes()->value; }

    public function getMeleeOffHandSpeedHastePercent()		{ return (string)$this->charXMLObj->characterTab->melee->offHandSpeed->attributes()->hastePercent; }
    public function getMeleeOffHandSpeedHasteRating()		{ return (string)$this->charXMLObj->characterTab->melee->offHandSpeed->attributes()->hasteRating; }	
    public function getMeleeOffHandSpeedValue()				{ return (string)$this->charXMLObj->characterTab->melee->offHandSpeed->attributes()->value; }

    public function getMeleePowerBase()				{ return (string)$this->charXMLObj->characterTab->melee->power->attributes()->base; }
    public function getMeleePowerEffective()		{ return (string)$this->charXMLObj->characterTab->melee->power->attributes()->effective; }	
    public function getMeleePowerIncreasedDps()		{ return (string)$this->charXMLObj->characterTab->melee->power->attributes()->increasedDps; }

    public function getMeleeHitRatingIncreasedHitPercent()	{ return (string)$this->charXMLObj->characterTab->melee->hitRating->attributes()->increasedHitPercent; }
    public function getMeleeHitRatingPenetration()			{ return (string)$this->charXMLObj->characterTab->melee->hitRating->attributes()->penetration; }	
    public function getMeleeHitRatingReducedArmorPercent()	{ return (string)$this->charXMLObj->characterTab->melee->hitRating->attributes()->reducedArmorPercent; }
    public function getMeleeHitRatingValue()				{ return (string)$this->charXMLObj->characterTab->melee->hitRating->attributes()->value; }

    public function getMeleeCritChancePercent()		{ return (string)$this->charXMLObj->characterTab->melee->critChance->attributes()->percent; }
    public function getMeleeCritChancePlusPercent()	{ return (string)$this->charXMLObj->characterTab->melee->critChance->attributes()->plusPercent; }	
    public function getMeleeCritChanceRating()		{ return (string)$this->charXMLObj->characterTab->melee->critChance->attributes()->rating; }

    public function getMeleeExpertiseAdditional()	{ return (string)$this->charXMLObj->characterTab->melee->expertise->attributes()->additional; }
    public function getMeleeExpertisePercent()		{ return (string)$this->charXMLObj->characterTab->melee->expertise->attributes()->percent; }	
    public function getMeleeExpertiseRating()		{ return (string)$this->charXMLObj->characterTab->melee->expertise->attributes()->rating; }
    public function getMeleeExpertiseValue()		{ return (string)$this->charXMLObj->characterTab->melee->expertise->attributes()->value; }

    public function getRangedWeaponSkillRating(){ return (string)$this->charXMLObj->characterTab->ranged->weaponSkill->attributes()->rating; }
    public function getRangedWeaponSkillValue()	{ return (string)$this->charXMLObj->characterTab->ranged->weaponSkill->attributes()->value; }	

    public function getRangedDamageDps()		{ return (string)$this->charXMLObj->characterTab->ranged->damage->attributes()->dps; }
    public function getRangedDamageMax()		{ return (string)$this->charXMLObj->characterTab->ranged->damage->attributes()->max; }	
    public function getRangedDamageMin()		{ return (string)$this->charXMLObj->characterTab->ranged->damage->attributes()->min; }
    public function getRangedDamagePercent()	{ return (string)$this->charXMLObj->characterTab->ranged->damage->attributes()->percent; }	
    public function getRangedDamageSpeed()		{ return (string)$this->charXMLObj->characterTab->ranged->damage->attributes()->speed; }	    

    public function getRangedSpeedHastePercent(){ return (string)$this->charXMLObj->characterTab->ranged->speed->attributes()->hastePercent; }
    public function getRangedSpeedHasteRating()	{ return (string)$this->charXMLObj->characterTab->ranged->speed->attributes()->hasteRating; }
    public function getRangedSpeedValue()		{ return (string)$this->charXMLObj->characterTab->ranged->speed->attributes()->value; }

    public function getRangedPowerBase()		{ return (string)$this->charXMLObj->characterTab->ranged->power->attributes()->base; }
    public function getRangedPowerEffective()	{ return (string)$this->charXMLObj->characterTab->ranged->power->attributes()->effective; }
    public function getRangedPowerIncreasedDps(){ return (string)$this->charXMLObj->characterTab->ranged->power->attributes()->increasedDps; }
    public function getRangedPowerPetAttack()	{ return (string)$this->charXMLObj->characterTab->ranged->power->attributes()->petAttack; }
    public function getRangedPowerPetSpell()	{ return (string)$this->charXMLObj->characterTab->ranged->power->attributes()->petSpell; }

    public function getRangedHitRatingIncreasedHitPercent()	{ return (string)$this->charXMLObj->characterTab->ranged->hitRating->attributes()->increasedHitPercent; }
    public function getRangedHitRatingPenetration()			{ return (string)$this->charXMLObj->characterTab->ranged->hitRating->attributes()->penetration; }
    public function getRangedHitRatingReducedArmorPercent()	{ return (string)$this->charXMLObj->characterTab->ranged->hitRating->attributes()->reducedArmorPercent; }
    public function getRangedHitRatingValue()				{ return (string)$this->charXMLObj->characterTab->ranged->hitRating->attributes()->value; }

    public function getRangedCritChancePercent()			{ return (string)$this->charXMLObj->characterTab->ranged->critChance->attributes()->percent; }
    public function getRangedCritChancePlusPercent()		{ return (string)$this->charXMLObj->characterTab->ranged->critChance->attributes()->plusPercent; }
    public function getRangedCritChanceRating()				{ return (string)$this->charXMLObj->characterTab->ranged->critChance->attributes()->rating; }

    public function getSpellBonusDamageArcane()				{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->arcane->attributes()->value; }
    public function getSpellBonusDamageFire()				{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->fire->attributes()->value; }
    public function getSpellBonusDamageFrost()				{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->frost->attributes()->value; }
    public function getSpellBonusDamageHoly()				{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->holy->attributes()->value; }
    public function getSpellBonusDamageNature()				{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->nature->attributes()->value; }
    public function getSpellBonusDamageShadow()				{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->shadow->attributes()->value; }
    public function getSpellBonusPetBonusAttack()			{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->petBonus->attributes()->attack; }
	public function getSpellBonusPetBonusDamage()			{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->petBonus->attributes()->damage; }
	public function getSpellBonusPetBonusFromType()			{ return (string)$this->charXMLObj->characterTab->spell->bonusDamage->petBonus->attributes()->fromType; }	

    public function getSpellBonusHealingValue()				{ return (string)$this->charXMLObj->characterTab->spell->bonusHealing->attributes()->value; }
    
    public function getSpellHitRatingIncreasedHitPercent()	{ return (string)$this->charXMLObj->characterTab->spell->hitRating->attributes()->increasedHitPercent; }
    public function getSpellHitRatingPenetration()			{ return (string)$this->charXMLObj->characterTab->spell->hitRating->attributes()->penetration; }
    public function getSpellHitRatingReducedResist()		{ return (string)$this->charXMLObj->characterTab->spell->hitRating->attributes()->reducedResist; }
    public function getSpellHitRatingValue()				{ return (string)$this->charXMLObj->characterTab->spell->hitRating->attributes()->value; }            

    public function getSpellCritChanceRating()	{ return (string)$this->charXMLObj->characterTab->spell->critChance->attributes()->rating; }
	public function getSpellArcaneCritChance()	{ return (string)$this->charXMLObj->characterTab->spell->critChance->arcane->attributes()->percent; }
	public function getSpellFireCritChance()	{ return (string)$this->charXMLObj->characterTab->spell->critChance->fire->attributes()->percent; }	
	public function getSpellFrostCritChance()	{ return (string)$this->charXMLObj->characterTab->spell->critChance->frost->attributes()->percent; }
	public function getSpellHolyCritChance()	{ return (string)$this->charXMLObj->characterTab->spell->critChance->holy->attributes()->percent; }	
	public function getSpellNatureCritChance()	{ return (string)$this->charXMLObj->characterTab->spell->critChance->nature->attributes()->percent; }
	public function getSpellShadowCritChance()	{ return (string)$this->charXMLObj->characterTab->spell->critChance->shadow->attributes()->percent; }	

    public function getSpellPenetrationValue()	{ return (string)$this->charXMLObj->characterTab->spell->penetration->attributes()->value; }
    
    public function getSpellCastingManaRegen()				{ return (string)$this->charXMLObj->characterTab->spell->manaRegen->attributes()->casting; }
    public function getSpellNotCastingManaRegen()			{ return (string)$this->charXMLObj->characterTab->spell->manaRegen->attributes()->notCasting; }
    
    public function getSpellHastePercent()		{ return (string)$this->charXMLObj->characterTab->spell->hasteRating->attributes()->hastePercent; }
    public function getSpellHasteRating()		{ return (string)$this->charXMLObj->characterTab->spell->hasteRating->attributes()->hasteRating; }
    
    public function getDefenseBaseArmor()		{ return (string)$this->charXMLObj->characterTab->defenses->armor->attributes()->base; }
    public function getDefenseEffectiveArmor()	{ return (string)$this->charXMLObj->characterTab->defenses->armor->attributes()->effective; }
    public function getDefenseArmorPercent()	{ return (string)$this->charXMLObj->characterTab->defenses->armor->attributes()->percent; }
    public function getDefensePetBonusArmor()	{ return (string)$this->charXMLObj->characterTab->defenses->armor->attributes()->petBonus; }            
    
    public function getDefenseDecreasePercent()	{ return (string)$this->charXMLObj->characterTab->defenses->defense->attributes()->decreasePercent; }
    public function getDefenseIncreasePercent()	{ return (string)$this->charXMLObj->characterTab->defenses->defense->attributes()->increasePercent; }
    public function getDefensePlusDefense()		{ return (string)$this->charXMLObj->characterTab->defenses->defense->attributes()->plusDefense; }
    public function getDefenseRating()			{ return (string)$this->charXMLObj->characterTab->defenses->defense->attributes()->rating; }
    public function getDefenseValue()			{ return (string)$this->charXMLObj->characterTab->defenses->defense->attributes()->value; }    

    public function getDefenseDodgeIncreasePercent()	{ return (string)$this->charXMLObj->characterTab->defenses->dodge->attributes()->increasePercent; }
    public function getDefenseDodgePercent()			{ return (string)$this->charXMLObj->characterTab->defenses->dodge->attributes()->percent; }
    public function getDefenseDodgeRating()				{ return (string)$this->charXMLObj->characterTab->defenses->dodge->attributes()->rating; }

    public function getDefenseParryIncreasePercent()	{ return (string)$this->charXMLObj->characterTab->defenses->parry->attributes()->increasePercent; }
    public function getDefenseParryPercent()			{ return (string)$this->charXMLObj->characterTab->defenses->parry->attributes()->percent; }
    public function getDefenseParryRating()				{ return (string)$this->charXMLObj->characterTab->defenses->parry->attributes()->rating; }

    public function getDefenseBlockIncreasePercent()	{ return (string)$this->charXMLObj->characterTab->defenses->block->attributes()->increasePercent; }
    public function getDefenseBlockPercent()			{ return (string)$this->charXMLObj->characterTab->defenses->block->attributes()->percent; }
    public function getDefenseBlockRating()				{ return (string)$this->charXMLObj->characterTab->defenses->block->attributes()->rating; }

    public function getDefenseResilienceDamagePercent()	{ return (string)$this->charXMLObj->characterTab->defenses->resilience->attributes()->damagePercent; }
    public function getDefenseResilienceHitPercent()	{ return (string)$this->charXMLObj->characterTab->defenses->resilience->attributes()->hitPercent; }
    public function getDefenseResilienceValue()			{ return (string)$this->charXMLObj->characterTab->defenses->resilience->attributes()->value; }

	public function getHeadSummary()		{ return $this->getGearSummary("0"); }
	public function getNeckSummary()		{ return $this->getGearSummary("1"); }
	public function getShoulderSummary()	{ return $this->getGearSummary("2"); }
	public function getShirtSummary()		{ return $this->getGearSummary("3"); }
	public function getChestSummary()		{ return $this->getGearSummary("4"); }
	public function getBeltSummary()		{ return $this->getGearSummary("5"); }
	public function getPantsSummary()		{ return $this->getGearSummary("6"); }
	public function getBootsSummary()		{ return $this->getGearSummary("7"); }
	public function getBracersSummary()		{ return $this->getGearSummary("8"); }
    public function getGauntletsSummary()	{ return $this->getGearSummary("9"); }
    public function getRing1Summary()		{ return $this->getGearSummary("10"); }
    public function getRing2Summary()		{ return $this->getGearSummary("11"); }
    public function getTrinket1Summary()	{ return $this->getGearSummary("12"); }
    public function getTrinket2Summary()	{ return $this->getGearSummary("13"); }
    public function getCapeSummary()		{ return $this->getGearSummary("14"); }
    public function getMainHandSummary()	{ return $this->getGearSummary("15"); }
    public function getOffHandSummary()		{ return $this->getGearSummary("16"); }
    public function getExtraSummary()		{ return $this->getGearSummary("17"); }
    public function getTabardSummary()		{ return $this->getGearSummary("18"); }
    public function getAmmoSummary()		{ return $this->getGearSummary("-1"); }

    /**
     * This function returns a gear for the provided slot number
     * @param string gearSlotNumber the gear slot number as returned by the armory
     * @return WowGearSummary, gear for the provided slot number
     */  
	protected function getGearSummary($gearSlotNumber) {
		if(empty($this->wowGearSummaryMap["'" . $gearSlotNumber . "'"])){
			$itemXml = XmlHelper::findOneElement($this->charXMLObj, "/characterInfo/characterTab/items/item[@slot='" . $gearSlotNumber . "']");
			if(!empty($itemXml)){
				$gearSummaryXML = $itemXml->asXML();
				$this->wowGearSummaryMap["'" . $gearSlotNumber . "'"] = new WowGearSummary($gearSummaryXML);
			} else {
				WowArmadaExceptionHandler::triggerWarning("Gear for slot " . $gearSlotNumber . " was not found.");
			}
		}
		return $this->wowGearSummaryMap["'" . $gearSlotNumber . "'"];
    }
    
	/**
     * The following functions returned calculated results
     */
     
    /**
     * This function returns the branch number of the main talent spec
     * @return int, the main branch number (1-3) or 0 if all branch have zero talents
     */     
 	public function getMainTalentBranch(){
	 	$result = 0;
	 	$branch1 = intval($this->getMainTalentBranch1());
	 	$branch2 = intval($this->getMainTalentBranch2());
	 	$branch3 = intval($this->getMainTalentBranch3());
	 	if(($branch1 <> 0) && ($branch1 > $branch2) && ($branch1 > $branch3)) {
		 	$result = 1;
	 	} elseif(($branch2 <> 0) && ($branch2 > $branch1) && ($branch2 > $branch3)) {
		 	$result = 2;
	 	} elseif(($branch3 <> 0) && ($branch3 > $branch1) && ($branch3 > $branch2)) {
		 	$result = 3;
	 	}
		return $result;
	}

    /**
     * This function returns the branch number of the alt talent spec
     * @return int, the main branch number (1-3) or 0 if all branch have zero talents
     */     
 	public function getAltTalentBranch(){
	 	$result = 0;
	 	$branch1 = intval($this->getAltTalentBranch1());
	 	$branch2 = intval($this->getAltTalentBranch2());
	 	$branch3 = intval($this->getAltTalentBranch3());
	 	if(($branch1 <> 0) && ($branch1 > $branch2) && ($branch1 > $branch3)) {
		 	$result = 1;
	 	} elseif(($branch2 <> 0) && ($branch2 > $branch1) && ($branch2 > $branch3)) {
		 	$result = 2;
	 	} elseif(($branch3 <> 0) && ($branch3 > $branch1) && ($branch3 > $branch2)) {
		 	$result = 3;
	 	}
		return $result;
	}
	
    /**
     * This function returns the Title of the character.
     * If the character has no titles, the name is returned.
     * @return string, ¨the character title/name
     */ 
    public function getFullName(){
	    $result = str_replace('%s', $this->getName(), $this->getTitle());
	    if(empty($result)){
		    $result = $this->getName();
	    }
	    return $result;
	}
	
    /**
     * This function returns the minimum spell damage from the
     * the elemental bonus damage list made of
     * - Arcane damage
     * - Fire damage
     * - Frost damage
     * - Holy damage
     * - Nature damage
     * - Shadow damage
     * @return string, the minimum bonus damage from elemental bonus damages
     */ 
    public function getMinSpellBonusDamage(){
	    $result = min($this->getSpellBonusDamageArcane(),
 					$this->getSpellBonusDamageFire(),
 					$this->getSpellBonusDamageFrost(),
					$this->getSpellBonusDamageHoly(),
 					$this->getSpellBonusDamageNature(),
 					$this->getSpellBonusDamageShadow());
	    return $result;
	}

    /**
     * This function returns the minimum spell crit chance from the
     * the elemental spell crit chance list made of
     * - Arcane damage
     * - Fire damage
     * - Frost damage
     * - Holy damage
     * - Nature damage
     * - Shadow damage
     * @return string, the minimum spell crit chance from elemental bonus damages
     */ 
    public function getMinSpellCriticalChance(){
	    $result = min($this->getSpellArcaneCritChance(),
 					$this->getSpellFireCritChance(),
 					$this->getSpellFrostCritChance(),
					$this->getSpellHolyCritChance(),
 					$this->getSpellNatureCritChance(),
 					$this->getSpellShadowCritChance());
	    return $result;
	}
	
}

?>
