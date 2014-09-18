<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('title',array(
		     'label'=>'Full Name',
		     'required'=>true));
		echo $this->Form->input('username',array('required'=>true));
		echo $this->Form->input('password',array('required'=>true));
		echo $this->Form->input('confirm_password',
		     array('type'=>'password','required'=>true));
		echo $this->Form->input('require_new_password',
		     array('label'=>'Require New Password at next login'));
		echo $this->Form->input('email');
		echo $this->Form->input('email_verified');
		echo $this->Form->input('role_id');
		echo $this->Form->input('position_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link('Home', '/'); ?></li>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
