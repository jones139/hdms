<div class="revisions form">
<?php echo $this->Form->create('Revision'); ?>
	<fieldset>
		<legend><?php echo __('Revision '.$this->request->data['Revision']['major_revision'].'_'.$this->request->data['Revision']['minor_revision'].' of document "'.$this->request->data['Doc']['title'].'" ('.$this->request->data['Doc']['docNo'].') <br/> Revision Status = '.$this->request->data['DocStatus']['title']);  ?></legend>
	<?php
		$this->Form->inputDefaults(array(
			'div' => false,
    			)
		);
		echo $this->Form->hidden('doc_status_id');
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('doc_id');
		echo $this->Form->hidden('major_revision');
		echo $this->Form->hidden('minor_revision');
		echo $this->Form->hidden('user_id');
		if ($this->request->data['Revision']['doc_status_id']==0) {
		   echo $this->Form->input('comment',array('label'=>'Revision Summary (Changes from last Major Revision)'));
		   echo $this->Form->submit('Update Revision Summary');
		} else {
		   echo $this->Form->input('comment',
		   	array('label'=>'Revision Summary (Changes from last Major Revision)',
			'disabled'=>true));
		}
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>


<?php 
      #############################
      # File Check out/in section #
      #############################
      echo '<h3>Attached File</h3>';

      echo '<p>';
      if ($this->request->data['Revision']['has_native']) {
      	 echo 'Attached File is <b>'.$this->request->data['Revision']['filename'].
	 '</b> (uploaded at '.$this->request->data['Revision']['native_date'].
	 ').  <br/>Checked in by <b>'.
	 $users[$this->request->data['Revision']['user_id']].'</b>.';
      } else {
      	 echo 'No File Attached';
      }
      echo '</p>';
      # Only show check-in/out buttons if the revision is a draft.
      echo '<p class="actions">';
      if ($this->request->data['DocStatus']['id']==0) {   
      	 if ($this->request->data['Revision']['is_checked_out']) {
            echo "File checked out by ".$users[$this->request->data['Revision']['check_out_user_id']]." on ".$this->request->data['Revision']['check_out_date'];
	    echo '<br/> ';
	    # Only show download and check-in buttons to the user
	    # who has the document checked out.
	    if ($this->request->data['Revision']['check_out_user_id'] == 
	          $authUserData['id']) {
            	  echo $this->Html->link('Download File',
             	       array('controller'=>'revisions','action'=>'download_file',
	                   $this->request->data['Revision']['id'],
			   'type'=>'native'));
	    	  echo '<nbrsp/> ';
            	  echo $this->Html->link('Check In File',
             	       array('controller'=>'revisions','action'=>'checkin_file',
	                   $this->request->data['Revision']['id']));
	    	  echo '<nbrsp/> ';
	    }
            echo $this->Html->link('Cancel Check Out',
             	 array('controller'=>'revisions','action'=>'cancel_checkout_file',
	                   $this->request->data['Revision']['id']));
      	 } else {
	    if ($this->request->data['Revision']['has_native']) {
      	       echo $this->Html->link('Check Out File',
                 array('controller'=>'revisions','action'=>'checkout_file',
			    $this->request->data['Revision']['id']));
               #echo "<br/>";
      	       #echo $this->Html->link('Upload PDF Version of File',
               #  array('controller'=>'revisions','action'=>'attach_file',
	       #		    $this->request->data['Revision']['id'],
		#	    'pdf'=>'true'),
                #     array('class'=>'button'));

	    } else {
      	       echo $this->Html->link('Attach File',
                 array('controller'=>'revisions','action'=>'attach_file',
			    $this->request->data['Revision']['id']));
	    }
         }
      } else {
         # If it is not a draft, we just show a view/download button
      	    echo $this->Html->link('View File',
                 array('controller'=>'revisions',
		        'action'=>'download_file',
			    $this->request->data['Revision']['id'],
			    'type'=>'native'));       
      }
      echo '</p>';


      #############################
      # PDF File section #
      #############################
      echo '<h3>PDF Version of File</h3>';
      echo '<p class="actions">';
      if ($this->request->data['Revision']['has_pdf']) {
         echo "PDF file uploaded at ".
	      $this->request->data['Revision']['pdf_date'];
	 if ($this->Time->fromstring(
	       $this->request->data['Revision']['pdf_date']) < 
	     $this->Time->fromstring(
               $this->request->data['Revision']['native_date'])) {
	       echo "<br/> <b>*** PDF File is Out of Date ***</b>";
 	 }
	 echo "<br/>";
      	 echo $this->Html->link('View PDF File',
      	 array('controller'=>'revisions',
            'action'=>'download_file',
	    $this->request->data['Revision']['id'],
				    'type'=>'pdf'));
      }

      # Only show PDF manipulation options for draft documents.
      if ($this->request->data['DocStatus']['id']==0) {   
         if ($this->request->data['Revision']['has_pdf']) {

      	    echo $this->Html->link('Re-generate PDF File',
      	    array('controller'=>'revisions',
              'action'=>'generate_pdf',
	      $this->request->data['Revision']['id']));
         } else {
            echo 'No PDF File Attached ';
      	    echo $this->Html->link('Generate PDF File',
      	    array('controller'=>'revisions',
              'action'=>'generate_pdf',
	      $this->request->data['Revision']['id']));
         }
         if ($authUserData['role_id']==1) {
             echo $this->Html->link('Manually Upload PDF',
                array('controller'=>'revisions','action'=>'attach_pdf',
			    $this->request->data['Revision']['id']));
	 }
      }
      echo '</p>';


      #############################
      # Extras File section #
      #############################
      echo '<h3>Extra File associated with Revision</h3>';
      echo '<p class="actions">';
      if ($this->request->data['Revision']['has_extras']) {
      	 echo $this->Html->link('View Extras',
      	 array('controller'=>'revisions',
            'action'=>'download_file',
	    $this->request->data['Revision']['id'],
				    'type'=>'extras'));
      } else {
         echo "No Extra File Attached.  ";
      }

      # Only show Extras manipulation options for draft documents.
      if ($this->request->data['DocStatus']['id']==0) {   
             echo $this->Html->link('Upload Extras File',
                array('controller'=>'revisions','action'=>'attach_extras',
			    $this->request->data['Revision']['id']));
      }
      echo '</p>';
				 


      ######################
      # Route List Section #
      ######################
      if ($lastRouteList_id) {
      	 echo '<h3>Route List Number '.$lastRouteList_id.' - status = '.$routeListStatuses[$lastRouteList_status].'</h3>';
         echo '<p class="actions">';
          if (isset($routeListEntries)) {
	     echo "<table>";
	     echo "<tr>";
	     echo "<th>User</th><th>Response</th><th>Date</th><th>Comment</th>";
	     echo "</tr>";
	     foreach ($routeListEntries as $rle) {
	        echo "<tr>";
	        echo "<td>".$users[$rle['RouteListEntries']['user_id']]."</td>";
		echo "<td>".$responses[$rle['RouteListEntries']['response_id']]."</td>";
		echo "<td>".$rle['RouteListEntries']['response_date']."</td>";
		echo "<td>".$rle['RouteListEntries']['response_comment']."</td>";
		# Only show approve buttons if route list is in 'submitted'
		# status.
		echo "<td class='actions'>";
	        if ($lastRouteList_status==1) {
		   if ($authUserData['id'] == $rle['RouteListEntries']['user_id'] && (!$rle['RouteListEntries']['response_id']>0)) {
      		      echo $this->Html->link('Approve/Reject Revision',
      		          array('controller'=>'routeLists','action'=>'approve',
		          $lastRouteList_id));
		   }
		   # Are we an administrator?
		   if (($authUserData['role_id']==1) &&
		      ($authUserData['id'] != $rle['RouteListEntries']['user_id']) && 
		      (!$rle['RouteListEntries']['response_date'])) {
      		      echo $this->Html->link('Approve/Reject Revision as Administrator',
      		          array('controller'=>'routeLists','action'=>'approve',
		          $lastRouteList_id,'forUser'=>$rle['RouteListEntries']['user_id']));
		   }
		}
		echo "</td>";
		echo "</tr>";
	     }
	     echo "</table>";
	     echo "<p class='actions'>";
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
         echo '<p class="actions">No Route List data present.  ';
	 // Only show create route list button for draft revisions.
	 if ($this->request->data['DocStatus']['id']==0) {
      	    	echo $this->Html->link('Create Route List',
             	     array('controller'=>'route_lists','action'=>'add',
			    'revision'=>$this->request->data['Revision']['id']));	
	} 
	echo '</p>';
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
	</ul>
</div>
