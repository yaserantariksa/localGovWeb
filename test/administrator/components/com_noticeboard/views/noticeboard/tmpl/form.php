<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="title">
					<?php echo JText::_( 'Title' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="title" id="title" size="32" maxlength="250" value="<?php echo $this->noticeboard->title;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="title">
					<?php echo JText::_( 'Description' ); ?>:
				</label>
			</td>
			<td>
				<?php 
					//get editor
					$editor =& JFactory::getEditor();
					echo $editor->display('description', $this->noticeboard->description, '550', '400', '60', '20', false );
				?>
			</td>
		</tr>

	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_noticeboard" />
<input type="hidden" name="id" value="<?php echo $this->noticeboard->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="noticeboard" />
</form>
