<div class="docs index">
     <script src="js/jquery.js"></script>
	<h2><?php echo __('Documents'); ?></h2>
	<?php echo $this->Form->hidden("a url"); ?>

	<?php if ($authUserData['role_id']>0) {  # Active Users
	#################################################################
	# Display for authenticated users
 	?>

	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('facilty_id','Facility'); ?></th>
			<th><?php echo $this->Paginator->sort('doc_type_id','Type'); ?></th>
			<th><?php echo $this->Paginator->sort('doc_subtype_id','Sub-Type'); ?></th>
			<th><?php echo $this->Paginator->sort('docNo','Doc. No.'); ?></th>
			<th><?php echo $this->Paginator->sort('title','Title'); ?></th>
			<th><?php echo "Issued Revision"; ?></th>
			<th><?php echo "Latest Draft Revision"; ?></th>
			<th>Create Revision</th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($docs as $doc): ?>
	<tr>
		<td>
			<?php echo $doc['Facility']['title']; ?>
		</td>
		<td>
			<?php echo $doc['DocType']['title']; ?>
		</td>
		<td>
			<?php echo $doc['DocSubtype']['title']; ?>
		</td>
		<td><?php echo h($doc['Doc']['docNo']); ?>&nbsp;</td>
		<td><?php echo h($doc['Doc']['title']); ?>&nbsp;</td>
		<td class='actions'>
		<?php 
		      $issued_rev = null;
		      foreach ($doc['Revision'] as $rev) {
		      	      if ($rev['doc_status_id']==2) $issued_rev = $rev;
		      }
		      if ($issued_rev != null) {
		      	 echo "<b>".$issued_rev['major_revision'].'_'.
				$issued_rev['minor_revision']."</b>";


			 if ($issued_rev['has_pdf']) {
			     echo $this->Html->image('download_icon.png',
                                 array('alt'=>'Download Icon',
			            'width'=>16,
				    'url'=>array('controller'=>'revisions',
                                    'action'=>'download_file',$issued_rev['id'])));
			 }

			 if ($issued_rev['has_native']) {
			     echo $this->Html->image('document_icon.png',
                                 array('alt'=>'Document Icon',
			            'width'=>16,
				    'url'=>array('controller'=>'revisions',
                                    'action'=>'download_file',$issued_rev['id'],
				    'native'=>true)));
                         }
		      	 echo "<br/>".$this->Html->link("View Rev",
			    array('controller'=>'revisions',
                            'action'=>'edit',$issued_rev['id']),
                            array('class'=>'actions')
			   ).' ';
			 echo '<br/>(',$this->Time->niceShort($issued_rev['doc_status_date']),')';

		      } else {
		         echo "none";
		      }
		 ?>&nbsp;</td>
		<td class="actions">
		<?php
		     $latest_rev = null;
		     if (sizeof($doc['Revision'])>0)
		     	$latest_rev = $doc['Revision'][sizeof($doc['Revision'])-1];
		      if ($latest_rev != null) {
		      	 echo "<b>".$latest_rev['major_revision'].'_'.
				$latest_rev['minor_revision']."</b>";

			 if ($latest_rev['has_pdf']) {
			     echo $this->Html->image('download_icon.png',
                                 array('alt'=>'Download Icon',
			            'width'=>16,
				    'url'=>array('controller'=>'revisions',
                                    'action'=>'download_file',$latest_rev['id'])));
			 }

			 if ($latest_rev['has_native']) {
			     echo $this->Html->image('document_icon.png',
                                 array('alt'=>'Document Icon',
			            'width'=>16,
				    'url'=>array('controller'=>'revisions',
                                    'action'=>'download_file',$latest_rev['id'],
				    'native'=>true)));
                         }
		      	 echo "<br/>".$this->Html->link("Edit Rev",
			    array('controller'=>'revisions',
                            'action'=>'edit',$latest_rev['id']),
                            array('class'=>'button')
			   ).' ';

			 echo '<br/>(',$this->Time->niceShort($latest_rev['doc_status_date']),')';

		      } else {
		         echo "none";
		      }
		?> </td>
                <td class="actions"> <?php
                  echo $this->Form->postLink('Major',
			array('controller'=>'revisions',
			      'action'=>'create_new_revision',$doc['Doc']['id'],
			      'major'=>'true'),
			      array(),__('Create Major Revision?'));

                  # if the latest revision is the issued revision, we can
                  # only create a new major revision, so do not show minor
		  # rev button.
		  if ($latest_rev['id']!=$issued_rev['id']) {	      
                    echo ":";
                    echo $this->Form->postLink('Minor',
			array('controller'=>'revisions',
                              'action'=>'create_new_revision',$doc['Doc']['id']),
			array(),__('Create Minor Revision?'));
                    }
		?>
		</td>
		<td class="actions">
		   <?php echo $this->Html->link(__('Edit Doc'), array('action' => 'edit', $doc['Doc']['id'])); ?>
			<!--<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $doc['Doc']['id']), array(), __('Are you sure you want to delete # %s?', $doc['Doc']['id'])); ?> -->
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>

<?php } else { 
#################################################################
# Display for non-authenticated users
?>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('docNo','Doc. No.'); ?></th>
			<th><?php echo $this->Paginator->sort('title','Title'); ?></th>
			<th><?php echo "Issued Revision"; ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($docs as $doc): ?>
		<?php 
		      $issued_rev = null;
		      foreach ($doc['Revision'] as $rev) {
		      	      if ($rev['doc_status_id']==2) $issued_rev = $rev;
		      }
		      if ($issued_rev != null) {

		      	 echo "<tr>";
			 echo "<td>".h($doc['Doc']['docNo'])."</td>";
			 echo "<td>".h($doc['Doc']['title'])."</td>";
			 echo "<td>";
		      	 echo $issued_rev['major_revision'].'_'.
				$issued_rev['minor_revision'].' ';

			 if ($issued_rev['has_pdf']) {
			     echo $this->Html->image('download_icon.png',
                                 array('alt'=>'Download Icon',
			            'width'=>16,
				    'url'=>array('controller'=>'revisions',
                                    'action'=>'download_file',$issued_rev['id'])));
			 }

			 if ($issued_rev['has_native']) {
			     echo $this->Html->image('document_icon.png',
                                 array('alt'=>'Document Icon',
			            'width'=>16,
				    'url'=>array('controller'=>'revisions',
                                    'action'=>'download_file',$issued_rev['id'],
				    'native'=>true)));
                         }

			 echo '<br/>(',$this->Time->niceShort($issued_rev['doc_status_date']),')';

			 echo "</td>";
			 echo "</tr>";
			 }
			 ?>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>


<?php } ?>



</div>


<!-- ****************************************************************** -->

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<div>
	<?php 
	      if ($authUserData['role_id']==1) {  # Administrators
		  echo "<li>".$this->Html->link(__('Create New Doc'), 
		                   array('action' => 'add'))."</li>";
	      }
	?>
	</div>

	
	<?php
		########################################################
		# Search Form
		echo $this->Form->create(null,array(
		     'action'=>'index',
		     'type'=>'get'
		));
		echo $this->Form->submit('Search',array('div'=>false));
		echo $this->Html->link('Show All', array(
		     'controller' => 'docs', 
		     'action' => 'index'));

		if (isSet($query['Facility']))
		    $facArr = $query['Facility'];
		else
		    # FIXME - should depend on size of $facilities
		    $facArr = array(0,1,2);
		echo $this->Form->input("Facility",
		     array(
		     'multiple'=>'true',
		     'options'=>$facilities, # provide by controller
		     'selected'=>$facArr,
		     'div'=>false)
		    );

		if (isSet($query['DocType']))
		    $docTypeArr = $query['DocType'];
		else
		    # FIXME - should depend on size of $doc_types
		    $docTypeArr = array(0,1,2,3,4);
		echo $this->Form->input("DocType",
		     array(
		     'multiple'=>'true',
		     'options'=>$doc_types,
		     'selected'=>$docTypeArr,
		     'div'=>false)
		    );

		if (isSet($query['DocSubType']))
		    $docSubTypeArr = $query['DocSubType'];
		else
		    # FIXME - should depend on size of doc_subtypes
		    $docSubTypeArr = array(0,1,2,3,4,5);
		echo $this->Form->input("DocSubType",
		     array(
		     'multiple'=>'true',
		     'options'=>$doc_subtypes,  # provide by controller.
		     'selected'=>$docSubTypeArr,
		     'div'=>false)
		    );

		if (isSet($query['title'])) 
		   $searchStr = $query['title'];
		else
		   $searchStr = '';
		echo $this->Form->input('Search.title',array(
		    'div'=>false,
		    'label'=>'Title/Doc. No. Search:',
		    'default'=>$searchStr));
		echo $this->Form->submit('Search',array('div'=>false));
		echo $this->Html->link('Show All', array(
		     'controller' => 'docs', 
		     'action' => 'index'));
		echo $this->Form->end();
	?>


</div>
