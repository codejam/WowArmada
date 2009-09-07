<?php
	// this template is made for the WowCharacterProfileView only
	if($this instanceof WowCharacterProfileView){
?>
<div class="waa_summary_main">
	<table>
	  <tr class="waa_summary_header">
	    <td class="waa_summary_avatar">
	      <img src="<?php print $this->getAvatarURL() ?>">
	      <div class="waa_summary_ach"><?php print $this->characterObject->getAchievementPoints() ?></div>
	    </td>
	    <td class="waa_summary_char_info" colspan="2">
	      <span class="waa_summary_char_name">
	      <?php
	      $title = $this->characterObject->getTitle();
		 if (!empty($title)) {
			 print $this->characterObject->getFullName();
		 } else {
			 print $this->characterObject->getName();
		 }
	      ?></span>
	      <?php
	       $guildName = trim($this->characterObject->getGuildName());
	       if (!empty($guildName)) {
	      	 print '<span class="waa_summary_char_guild">' . "&lt;" . $guildName ."&gt;" . "</span>";
	       } ?>
	      <span class="waa_summary_char_stuff">Level <?php print $this->characterObject->getLevel() ?> <?php print $this->characterObject->getRace() ?> <?php print $this->characterObject->getWowClass() ?></span>
	
	      <div class="waa_summary_talents">
			<?php
			$mainTalentBuild = trim($this->characterObject->getMainTalentPrim());
			if(!empty($mainTalentBuild)) {
				print '<img src="'. $this->getMainTalentIconURL() . '">';
		        print '<span class="waa_summary_talent_spec">' . $this->characterObject->getMainTalentPrim() . '</span>';
		        print '<span class="waa_summary_talent_trees"><a href="http://www.wow-europe.com/en/info/basics/talents/' . strtolower($this->characterObject->getWowClass()) . 'talents.html?tal=' . $this->characterObject->getMainTalentBuild() . '">' . $this->characterObject->getMainTalentBranch1() . '/' . $this->characterObject->getMainTalentBranch2() . '/' . $this->characterObject->getMainTalentBranch3() . '</a></span>';
				} ?>
			<?php
			$altTalentBuild = trim($this->characterObject->getAltTalentPrim());
			if(!empty($altTalentBuild)) {
				print '<img src="'. $this->getAltTalentIconURL() . '">';
		        print '<span class="waa_summary_talent_spec">' . $this->characterObject->getAltTalentPrim() . '</span>';
		        print '<span class="waa_summary_talent_trees"><a href="http://www.wow-europe.com/en/info/basics/talents/' . strtolower($this->characterObject->getWowClass()) . 'talents.html?tal=' . $this->characterObject->getAltTalentBuild() . '">' . $this->characterObject->getAltTalentBranch1() . '/' . $this->characterObject->getAltTalentBranch2() . '/' . $this->characterObject->getAltTalentBranch3() . '</a></span>';
				} ?>
	      </div>
	    </td>
	 </tr>
	 <tr>
	  <td class="waa_summary_stat_health" colspan="3">
	    <center><?php print $this->characterObject->getHealth() ?></center>
	  </td>
	 </tr>
	
	 <tr>
	  <td class="waa_summary_stat_<?php print $this->characterObject->getSecondBarType() ?>" colspan="3">
	    <center><?php print $this->characterObject->getSecondBarValue() ?></center>
	  </td>
	 </tr>
	</table>
	<table class="waa_summary_professions">
		<tr>
			<td class="waa_summary_profession_name">
				<img src="<?php print $this->getFirstProfessionIconURL() ?>">
			</td>
			<td class="waa_summary_profession_name">
				<?php print $this->characterObject->getFirstProfession() ?>
			</td>		
		   	<td class="waa_summary_profession_skill" colspan="2">
				<?php
				$firstProfession = trim($this->characterObject->getFirstProfession());
				if(!empty($firstProfession)) {
					 print $this->characterObject->getFirstProfessionSkill() . "/" . $this->characterObject->getFirstProfessionMax();
				} ?>
		   	</td>
		</tr>
		<tr>
			<td class="waa_summary_profession_name">
				<img src="<?php print $this->getSecondProfessionIconURL() ?>">
			</td>
			<td class="waa_summary_profession_name">
				<?php print $this->characterObject->getSecondProfession() ?>
			</td>
		   	<td class="waa_summary_profession_skill">
				<?php
				$secondProfession = trim($this->characterObject->getSecondProfession());
				if(!empty($secondProfession)) {
					 print $this->characterObject->getSecondProfessionSkill() . "/" . $this->characterObject->getSecondProfessionMax();
				} ?>
		   	</td>
		   	<td class="waa_summary_last_update">
				<?php print $this->characterObject->getVersionDate() ?>
		   	</td>
		</tr>
	</table>
	<div class="waa_summary_footer">
		Rendered using the World of Warcraft Armory Adapter (Wow Armada) classes, version 0.2 - Copyright &copy; 2009 codejam
	</div>
</div>
<?php
	// this template is made for the WowCharacterProfileView only
	} else {
		print "This template (summary) was not used with the proper view object.";
	}
?>

