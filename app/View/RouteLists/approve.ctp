<div class="routeLists form">
<?php echo $this->Form->create('RouteListEntry'); ?>
	<fieldset>
		<legend><?php echo __('Approve Revision '.$this->data['RouteList']['Revision']['major_revision'].'_'
		.$this->data['RouteList']['Revision']['minor_revision']); 
		echo " of document ".$this->data['RouteList']['Revision']['Doc']['docNo'];
		echo " (".$this->data['RouteList']['Revision']['Doc']['title'].")";
		?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('route_list_id');
		echo $this->Form->input('response_id');
		echo $this->Form->input('response_comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit Response')); ?>

<?php
###############
# Back Button #
###############
echo $this->Html->link('Back',
      array('controller'=>'revisions','action'=>'edit',$this->data['RouteList']['revision_id'])); ?>


</div>

