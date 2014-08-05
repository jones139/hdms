<div class="routeLists form">
<?php echo $this->Form->create('RouteList'); ?>
	<fieldset>
		<legend><?php echo __('Submit Route List'); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('revision_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit Route List for Approval?')); ?>

<?php
###############
# Back Button #
###############
echo $this->Html->link('Back',
      array('controller'=>'revisions','action'=>'edit',$this->data['RouteList']['revision_id'])); ?>


</div>

