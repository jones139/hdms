<div class="revisions form">
<?php echo $this->Form->create('Revision'); ?>
	<fieldset>
		<legend><?php echo __('Editing Revision '.$this->request->data['Revision']['major_revision'].'_'.$this->request->data['Revision']['minor_revision'].' of document "'.$this->request->data['Doc']['title'].'" ('.$this->request->data['Doc']['docNo'].')');  ?></legend>
	<?php
		echo $this->Form->hidden('doc_status_id');
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('doc_id');
		echo $this->Form->hidden('major_revision');
		echo $this->Form->hidden('minor_revision');
		echo $this->Form->hidden('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>


<?php 
      #############################
      # File Check out/in section #
      #############################
      echo '<h3>Document File</h3>';

      echo '<p>';
      if ($this->request->data['Revision']['has_native']) {
      	 echo 'Current File is '.$this->request->data['Revision']['filename'].' (uploaded at '.$this->request->data['Revision']['native_file_date'].').';
      } else {
      	 echo 'No File Attached';
      }
      echo '</p>';
      echo '<p>';
      if ($this->request->data['Revision']['is_checked_out']) {
          echo "File checked out by ".$this->request->data['Revision']['check_out_user_id']." on ".$this->request->data['Revision']['check_out_date'];
	  echo '<nbrsp/> ';
          echo $this->Html->link('Check In File',
             array('controller'=>'revisions','action'=>'check_in_file',
	                   $this->request->data['Revision']['id']));
	  echo '<nbrsp/> ';
          echo $this->Html->link('Cancel Check Out',
             array('controller'=>'revisions','action'=>'cancel_checkout_file',
	                   $this->request->data['Revision']['id']));
      } else {
      	  echo $this->Html->link('Checkout File',
          array('controller'=>'revisions','action'=>'checkout_file',
			    $this->request->data['Revision']['id']));
      }
      echo '</p>';

      ###########################
      # Create revision section #
      ###########################
      echo $this->Html->link('Create New Minor Revision',
             array('controller'=>'revisions','action'=>'create_new_revision',
	                   $this->request->data['Revision']['doc_id']));
      echo $this->Html->link('Create New Major Revision',
             array('controller'=>'revisions','action'=>'create_new_revision',
	                   $this->request->data['Revision']['doc_id'],'major:true'));

      ######################
      # Route List Section #
      ######################
      echo '<h3>Route List </h3>';
      echo '<p>';
      if ($this->request->data['RouteList']) {
          if ($this->request->data['RouteList'][0]['revision_id']) {
      	     echo $this->Html->link('View Route List',
             array('controller'=>'route_lists','action'=>'view',
			    $this->request->data['RouteList'][0]['id']));
          } else {
      	    echo 'No Route List Attached';
          }
      } else {
         echo 'No Route List data present - ';
      	 echo $this->Html->link('Create Route List',
             array('controller'=>'route_lists','action'=>'add',
			    'revision'=>$this->request->data['Revision']['id']));
      }
      echo '</p>';

?>
<?php echo $this->Html->link('Back',
      array('controller'=>'revisions','action'=>'index')); ?>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('List Revisions'), array('action' => 'index')); ?></li>
		
		<li><?php echo $this->Html->link(__('List Route Lists'), array('controller' => 'route_lists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List'), array('controller' => 'route_lists', 'action' => 'add')); ?> </li>
	</ul>
</div>
