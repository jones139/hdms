<div class="settings index">
<?php
	echo "<h1>Edit Settings</h1>";
	echo $this->Form->create('Setting');
	echo $this->Form->input('id');
	echo $this->Form->input('email_enabled',array(
	'label'=>'Enable Email Notifications'));
	echo $this->Form->input('issue_notify_list',array(
	'label'=>'Semicolon separated list of email addresses to notify of document issue'));
	echo $this->Form->input('pdf_url');
	echo $this->Form->input('pdf_user');
	echo $this->Form->input('pdf_passwd');
	echo $this->Form->end('Save Settings');
?>

</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
	</ul>
</div>
