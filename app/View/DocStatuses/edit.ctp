<div class="docStatuses form">
<?php echo $this->Form->create('DocStatus'); ?>
	<fieldset>
		<legend><?php echo __('Edit Doc Status'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DocStatus.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('DocStatus.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Doc Statuses'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
	</ul>
</div>
