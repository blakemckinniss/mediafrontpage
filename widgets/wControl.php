<?php
$wdgtControl = array("type" => "inline", "function" => "widgetControl();");
function widgetControl() {
	global $shortcut;

	echo "        <h1>Control</h1>";
	echo "        <ul>";
	foreach( $shortcut as $shortcutlabel => $shortcutpath) {
		echo "          <li><a class='shortcut' href='".$shortcutpath."' target=middle>".$shortcutlabel."</a><br/></li>";
	}
	echo "        </ul>";
}
?>