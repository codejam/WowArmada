<?php
	// this template is made for the WowCharacterProfileView only
	if($this instanceof WowCharacterProfileView){
?>
<div class="waa_main">
	<div class="waa_stat_block" id="base">
		<div class="waa_stat_block_title">Base Stats</div>
		<table>
			<tr>
				<td class="waa_stat_name">Strength:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getStrengthEffective() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Agility:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getAgilityEffective() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Stamina:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getStaminaEffective() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Intellect:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getIntellectEffective() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Spirit:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getSpiritEffective() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Armor:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getArmorEffective() ?>
				</td>
			</tr>	
		</table>
	</div>	
	<div class="waa_stat_block" id="melee">
		<div class="waa_stat_block_title">Melee</div>
		<table>
			<tr>
				<td class="waa_stat_name">Damage:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMeleeMainHandDamageMin() . '-' . $this->characterObject->getMeleeMainHandDamageMax() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Speed:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMeleeMainHandSpeedValue() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Power:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMeleePowerEffective() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Hit Rating:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMeleeHitRatingValue() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Crit Change:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMeleeCritChancePercent() ?>%
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Expertise:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMeleeExpertiseValue() ?>
				</td>
			</tr>	
		</table>
	</div>
	<div class="waa_stat_block" id="defense">
		<div class="waa_stat_block_title">Defense</div>
		<table >
			<tr>
				<td class="waa_stat_name">Armor:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getDefenseEffectiveArmor() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Defense:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getDefenseValue()+$this->characterObject->getDefensePlusDefense() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Dodge:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getDefenseDodgePercent() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Parry:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getDefenseParryPercent() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Block:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getDefenseBlockPercent() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Resilience:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getDefenseResilienceValue() ?>
				</td>
			</tr>			
		</table>
	</div>	
	<div class="waa_stat_block" id="spell">
		<div class="waa_stat_block_title">Spell</div>
		<table>
			<tr>
				<td class="waa_stat_name">Bonus Damage:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMinSpellBonusDamage() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Bonus Healing:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getSpellBonusHealingValue() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Hit Rating:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getSpellHitRatingValue() ?> (+<?php print $this->characterObject->getSpellHitRatingIncreasedHitPercent() ?>%)
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Crit Chance:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getMinSpellCriticalChance() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Haste Rating:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getSpellHasteRating() ?> (+<?php print $this->characterObject->getSpellHastePercent() ?>%)
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Mana Regen:</td>
				<td class="waa_stat_value">
					<?php printf('%u',$this->characterObject->getSpellNotCastingManaRegen()) ?> (<?php printf('%u',$this->characterObject->getSpellCastingManaRegen()) ?>)
				</td>
			</tr>			
		</table>
	</div>
	<div class="waa_stat_block" id="ranged">
		<div class="waa_stat_block_title">Ranged</div>
		<table>
			<tr>
				<td class="waa_stat_name">Damage:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getRangedDamageMin() . '-' . $this->characterObject->getRangedDamageMax() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Speed:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getRangedSpeedValue() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Power:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getRangedPowerEffective() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Hit Rating:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getRangedHitRatingValue() ?>
				</td>
			</tr>
			<tr>
				<td class="waa_stat_name">Crit Change:</td>
				<td class="waa_stat_value">
					<?php print $this->characterObject->getRangedCritChancePercent() ?>%
				</td>
			</tr>
		</table>
	</div>
	<div class="waa_footer">
		Rendered using the World of Warcraft Armory Adapter (Wow Armada) classes, version 0.2 - Copyright &copy; 2009 codejam
	</div>
</div>
<?php
	// this template is made for the WowCharacterProfileView only
	} else {
		print "This template (detail) was not used with the proper view object.";
	}
?>


