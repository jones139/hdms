<div class="routeListEntries form">
<h2>Edit Route List</h2>
<div>
<h3>Current Entries:</h3>
<?php
   foreach (array_keys($entries) as $entry_id) {
      echo "<li>".$users[$entries[$entry_id]].' ';
#array(’confirm’ => ’Are you sure?’)
      echo $this->Form->postLink('Delete',
           array('controller'=>'route_lists','action'=>'delete_approver',$entry_id));
      echo "</li>";
}
?>
</div>
<div>
<h3></h3> <!-- FIXME - fiddle to get a space - should use CSS!!! -->
<h3>Add Approver to Route List</h3>
<?php echo $this->Form->create('RouteListEntry'); ?>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('route_list_id');
		echo $this->Form->input('user_id');
	?>
<?php echo $this->Form->end(__('Add Approver')); ?>

<div class="actions button">
<?php
###############
# Back Button #
###############
echo $this->Html->link('Back',
      array('controller'=>'revisions','action'=>'edit',$revision_id)); 
?>
</div>
</div>

</div>

