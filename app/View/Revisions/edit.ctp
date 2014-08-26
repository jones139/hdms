<div class="revisions form">
<?php echo $this->Form->create('Revision'); ?>
	<fieldset>
		<legend><?php echo __('Editing Revision '.$this->request->data['Revision']['major_revision'].'_'.$this->request->data['Revision']['minor_revision'].' of document "'.$this->request->data['Doc']['title'].'" ('.$this->request->data['Doc']['docNo'].') - Revision Status = '.$this->request->data['DocStatus']['title']);  ?></legend>
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
      # Only show check-in/out buttons if the revision is a draft.
      if ($this->request->data['DocStatus']['id']==0) {   
      	 echo '<p>';
      	 if ($this->request->data['Revision']['is_checked_out']) {
            echo "File checked out by ".$this->request->data['Revision']['check_out_user_id']." on ".$this->request->data['Revision']['check_out_date'];
	    echo '<nbrsp/> ';
            echo $this->Html->link('Check In File',
             	 array('controller'=>'revisions','action'=>'checkin_file',
	                   $this->request->data['Revision']['id']));
	    echo '<nbrsp/> ';
            echo $this->Html->link('Cancel Check Out',
             	 array('controller'=>'revisions','action'=>'cancel_checkout_file',
	                   $this->request->data['Revision']['id']));
      	 } else {
	    if ($this->request->data['Revision']['has_native']) {
      	       echo $this->Html->link('Check Out File',
                 array('controller'=>'revisions','action'=>'checkout_file',
			    $this->request->data['Revision']['id']));
               echo "<br/>";
      	       echo $this->Html->link('Upload PDF Version of File',
                 array('controller'=>'revisions','action'=>'attach_file',
			    $this->request->data['Revision']['id'],
			    'pdf'=>'true'),
                     array('class'=>'button'));

	    } else {
      	       echo $this->Html->link('Attach File',
                 array('controller'=>'revisions','action'=>'attach_file',
			    $this->request->data['Revision']['id']));
	    }
         echo '</p>';
         }
      } else {
         # If it is not a draft, we just show a view/download button
      	    echo $this->Html->link('View File',
                 array('controller'=>'revisions','action'=>'download_file',
			    $this->request->data['Revision']['id']));       
      }

      ######################
      # Route List Section #
      ######################
      if ($lastRouteList_id) {
      	 echo '<h3>Route List Number '.$lastRouteList_id.' - status = '.$routeListStatuses[$lastRouteList_status].'</h3>';
         echo '<p>';
          if (isset($routeListEntries)) {
	     echo "<ol>";
	     foreach ($routeListEntries as $rle) {
	        echo "<li>".$users[$rle['RouteListEntries']['user_id']];
		echo " : ".$responses[$rle['RouteListEntries']['response_id']];
		echo " : ".$rle['RouteListEntries']['response_date'];
		echo " : ".$rle['RouteListEntries']['response_comment'];
		# Only show approve buttons if route list is in 'submitted'
		# status.
	        if ($lastRouteList_status==1) {
		   if ($authUserData['id'] == $rle['RouteListEntries']['user_id'] && (!$rle['RouteListEntries']['response_id']>0)) {
      		      echo $this->Html->link('Approve Revision',
      		          array('controller'=>'routeLists','action'=>'approve',
		          $lastRouteList_id));
		   }
		   # Are we an administrator?
		   if (($authUserData['role_id']==1) &&
		      ($authUserData['id'] != $rle['RouteListEntries']['user_id']) && 
		      (!$rle['RouteListEntries']['response_date'])) {
      		      echo $this->Html->link('Approve Revision as Administrator',
      		          array('controller'=>'routeLists','action'=>'approve',
		          $lastRouteList_id));
		   }
		}
		echo "</li>";
	     }
	     echo "</ol>";
	     # Allow the user to edit or submit draft or cancelled route lists.
	     if ($lastRouteList_status==0 || $lastRouteList_status==3) {
      	       echo $this->Html->link('Edit Route List',
             	  array('controller'=>'route_lists','action'=>'edit',
			    $lastRouteList_id));
	       echo " - ";
      	       echo $this->Html->link('Submit Route List',
             	  array('controller'=>'route_lists','action'=>'submit',
			    $lastRouteList_id));
	     } else if ($lastRouteList_status==1) { # Only allow in-progress route lists to be cancelled.
      	       echo $this->Html->link('Cancel Route List',
             	  array('controller'=>'route_lists','action'=>'cancel',
			    $lastRouteList_id));
             }
          } else {
            echo "<h3>Route List</h3>";
      	    echo 'No Route List Attached';
          }
      } else {
         echo "<h3>Route List</h3>";
         echo 'No Route List data present - ';
      	 echo $this->Html->link('Create Route List',
             array('controller'=>'route_lists','action'=>'add',
			    'revision'=>$this->request->data['Revision']['id']));
      }
      echo '</p>';

?>

<div class="actions">
<?php
###############
# Back Button #
###############
echo $this->Html->link('Back',
      array('controller'=>'docs','action'=>'index')); ?>
</div>

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
