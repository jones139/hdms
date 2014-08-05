<div class="routeLists form">
<?php echo $this->Form->create('RouteList'); ?>
	<fieldset>
		<legend><?php echo __('Cancel Route List'); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('revision_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Cancel Route List?')); ?>

<?php
###############
# Back Button #
###############
echo $this->Html->link('Back',
      array('controller'=>'revisions','action'=>'edit',$this->data['RouteList']['revision_id'])); ?>


</div>

