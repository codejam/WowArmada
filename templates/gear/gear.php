<?php
	// this template is made for the WowCharacterProfileView only
	if($this instanceof WowCharacterProfileWithGearView){
?>
<div class="waa_main">

<?php
	function displayGear($theViewObject, $aGearObject, $aGearName){
		if(is_null($theViewObject) || is_null($aGearObject) || is_null($aGearName)){
			return;
		}
		print '<div class="waa_item" id="head"><div class="waa_item_title">' . $aGearName . '</div>' . "\n";
		print '<div class="waa_item_description">' . "\n";
		print '<div class="waa_item_view">' . "\n";
		print '<a href="' . $theViewObject->getGearItemDBURL($aGearObject) . '">' . "\n";
		print '<img src="' . $theViewObject->getGearMediumIconURL($aGearObject) . '"/>' . "\n";
		print '</a>';
		print '</div>' . "\n";
		print '<div class="waa_item_name">';
		print '<a class="waa_quality_' . $aGearObject->getQuality() . '" href="' . $theViewObject->getGearItemDBURL($aGearObject) . '">' . "\n";
		print $aGearObject->getName();
		print '</a>';
		print '</div>' . "\n";
		print '<div class="waa_item_level">';
		print 'Level: ' . $aGearObject->getLevel();
		print '</div>' . "\n";
		print '<div>' . $theViewObject->getGearEnchantLink($aGearObject) .'</div>' . "\n";
		print '<div>' . $theViewObject->getGearGem0Link($aGearObject) .'</div>' . "\n";
		print '<div>' . $theViewObject->getGearGem1Link($aGearObject) .'</div>' . "\n";
		print '<div>' . $theViewObject->getGearGem2Link($aGearObject) .'</div>' . "\n";
		print '</div>' . "\n";
		print '</div>' . "\n";
	}
	
	displayGear($this, $this->characterObject->getHead(), 'Head');
	displayGear($this, $this->characterObject->getNeck(), 'Neck');
	displayGear($this, $this->characterObject->getShoulder(), 'Shoulder');
	displayGear($this, $this->characterObject->getCape(), 'Cape');
	displayGear($this, $this->characterObject->getChest(), 'Chest');
	displayGear($this, $this->characterObject->getBracers(), 'Bracers');
	displayGear($this, $this->characterObject->getGauntlets(), 'Gauntlets');
	displayGear($this, $this->characterObject->getBelt(), 'Belt');
	displayGear($this, $this->characterObject->getPants(), 'Pants');
	displayGear($this, $this->characterObject->getBoots(), 'Boots');
	displayGear($this, $this->characterObject->getRing1(), 'Ring 1');
	displayGear($this, $this->characterObject->getRing2(), 'Ring 2');
	displayGear($this, $this->characterObject->getTrinket1(), 'Trinket 1');
	displayGear($this, $this->characterObject->getTrinket2(), 'Trinket 2');
	displayGear($this, $this->characterObject->getMainHand(), 'Main Hand');
	displayGear($this, $this->characterObject->getOffHand(), 'Off Hand');
	displayGear($this, $this->characterObject->getExtra(), 'Range / Misc');
?>
	
	<div class="waa_footer">
		Rendered using the World of Warcraft Armory Adapter (Wow Armada) classes, version 0.2 - Copyright &copy; 2009 codejam
	</div>
</div>
<?php
	// this template is made for the WowCharacterProfileWithGearView only
	} else {
		print "This template (gear) was not used with the proper view object of type WowCharacterProfileWithGearView.";
	}
?>
