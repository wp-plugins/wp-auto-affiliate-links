<?php 

$aalCustomFeed = new aalModule('customfeed','Custom Feed');


$aalCustomFeed->aalModuleHook('content','aalCustomFeedDisplay');
function aalCustomFeedDisplay() {

	?>

	Comming soon
	<?

}



$aalModules[] = $aalCustomFeed;

?>
