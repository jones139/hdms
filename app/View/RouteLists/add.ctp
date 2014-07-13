<div class="routeLists form">
<?php echo $this->Form->create('RouteList'); ?>
	<fieldset>
		<legend><?php echo __('Add Route List'); ?></legend>
	<?php
		echo $this->Form->input('revision_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Route Lists'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route List Entries'), array('controller' => 'route_list_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List Entry'), array('controller' => 'route_list_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
