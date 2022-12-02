<?php 

/**
* @version		1.0
* @package		Noticeboard
* @copyright	Copyright (C) 2009 SP. All rights reserved.
* @license		GNU/GPL
*  
*/

	// no direct access
	defined('_JEXEC') or die('Restricted access'); 
?>

<style type="text/css">

.hide, .qslide, #qscroller1 {
	line-height:110%;
	font-size: <?php echo $nb_text_size; ?>pt;
	padding: <?php echo $nb_spacing; ?>px;	
	background: <?php echo $nb_bgcolor; ?>;	
	width: <?php echo $nb_width; ?>px;	
}

.hide {
	visibility: hidden;
	position: absolute;
	top: -400px;
	font-family: verdana, arial, sans-serif;
}

#qscroller1 {
	height: <?php echo $nb_height; ?>px;
	border: <?php echo $nb_border_width; ?>px <?php echo $nb_border_style; ?> <?php echo $nb_border_color; ?>;
}

.qslide {
}

</style>

<div id="qscroller1"></div>

<div class="hide">

	<?php 
		foreach($lists as $row){
    ?>

				<div class="qslide">

	<?php		
					if($nb_show_title == "yes"){
            			echo "<p><strong>".$row->title."</strong></p>";
					}
            		echo $row->description;
    ?>
				</div>
    
	<?php	
			
        }
    ?>
</div>




