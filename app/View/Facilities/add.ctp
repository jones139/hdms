<div class="facilities form">
<?php echo $this->Form->create('Facility'); ?>
	<fieldset>
		<legend><?php echo __('Add Facility'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('codestr');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Facilities'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
	</ul>
</div>
