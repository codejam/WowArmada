<h1>Wow Armada - World Of Warcraft Armory Adapter</h1>
<h2>Raw Template</h2>
<h3>Raw XML Information from WowCharacterProfile</h3>
<div>
<?php print $this->characterObject->getArmoryRawXML() ?>
</div>
<h3>Raw WowCharacterProfile PHP Object</h3>
<div>
<?php 
	$charObj = new ReflectionClass(WowCharacterProfile);
	$methods = $charObj->getMethods();
	print '<table>';
  	foreach($methods as $reflect) {
    print '<tr><td>' . $reflect->getName() . '</td><td>';
    if($reflect->isPublic() && $reflect->getNumberOfParameters() == 0){
	    	print $reflect->invoke($this->characterObject);
    	} else {
	    	print 'Value required.';
		}
    print '</td></tr>';		
	}
  print '</table>';
?>
</div>