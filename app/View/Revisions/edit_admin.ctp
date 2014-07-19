<div class="revisions form">
<?php echo $this->Form->create('Revision'); ?>
	<fieldset>
		<legend><?php echo __('Edit Revision'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('doc_id');
		echo $this->Form->input('major_revision');
		echo $this->Form->input('minor_revision');
		echo $this->Form->input('user_id');
		echo $this->Form->input('doc_status_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
<?php echo $this->Html->link('Upload File',
      array('controller'=>'revisions','action'=>'upload_file',$this->request->data['Revision']['id']));

?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Revision.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Revision.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doc Statuses'), array('controller' => 'doc_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc Status'), array('controller' => 'doc_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route Lists'), array('controller' => 'route_lists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List'), array('controller' => 'route_lists', 'action' => 'add')); ?> </li>
	</ul>
</div>
