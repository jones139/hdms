<div class="docs form">
<?php echo $this->Form->create('Doc'); ?>
	<fieldset>
		<legend><?php echo __('Add Doc'); ?></legend>
	<?php
		echo $this->Form->input('facility_id');
		echo $this->Form->input('docType');
		echo $this->Form->input('docNo');
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Docs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Facilities'), array('controller' => 'facilities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facility'), array('controller' => 'facilities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
	</ul>
</div>
