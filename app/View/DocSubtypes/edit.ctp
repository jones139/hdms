<div class="docSubtypes form">
<?php echo $this->Form->create('DocSubtype'); ?>
	<fieldset>
		<legend><?php echo __('Edit Doc Subtype'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DocSubtype.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('DocSubtype.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Doc Subtypes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
	</ul>
</div>
