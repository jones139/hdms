<div class="routeListEntries form">
<h3>Current Route List</h3>
<?php
   foreach (array_keys($entries) as $entry_id) {
      echo "<li>".$entry_id.' - '.$entries[$entry_id]." - ".$users[$entries[$entry_id]];
#array(’confirm’ => ’Are you sure?’)
      echo $this->Form->postLink('Delete',
           array('controller'=>'route_lists','action'=>'delete_approver',$entry_id));
      echo "</li>";
}
?>

<?php echo $this->Form->create('RouteListEntry'); ?>
	<fieldset>
		<legend><?php echo __('Add Approver to Route List'); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('route_list_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

<?php
###############
# Back Button #
###############
echo $this->Html->link('Back',
      array('controller'=>'revisions','action'=>'edit',$revision_id)); 

?>


</div>

