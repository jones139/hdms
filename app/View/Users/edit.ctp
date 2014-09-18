<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		if ($authUserData['role_id']==1) {   # Administrator
		   echo $this->Form->input('username');
		   echo $this->Form->input('require_new_password',
		   	array('label'=>'Require New Password at next login'));
		} else {
		   echo $this->Form->input('username',array('disabled'=>'disabled'));
		}
		// Enforce changing password if require_new_password is set.
		if ($this->request->data['User']['require_new_password']) {
		   $required = true;
		   echo "<b>***Password Change Required***</b>";
                }
		else
		   $required = false;
		echo $this->Form->input('password',array('required'=>$required));
		echo $this->Form->input('confirm_password',array(
		     'type'=>'password','required'=>$required));
		echo $this->Form->input('title',array('label'=>'Full Name'));

		echo $this->Form->input('email_verified',array('label'=>'Enable Email Notifications'));
		echo $this->Form->input('email');

		# Some fields can only be edited by an administrator
		if ($authUserData['role_id']==1) {
		   echo $this->Form->input('role_id');
		   echo $this->Form->input('position_id');
		}
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
         <li><?php echo $this->Html->link('Home', '/'); ?></li>
	</ul>
</div>
