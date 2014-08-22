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
			<th><?php echo "Issued"; ?></th>
			<th><?php echo "Latest"; ?></th>
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
		<td>
		<?php 
		      $issued_rev = null;
		      foreach ($doc['Revision'] as $rev) {
		      	      if ($rev['doc_status_id']==2) $issued_rev = $rev;
		      }
		      if ($issued_rev != null) {
		      	 echo $this->Html->link($issued_rev['major_revision'].'_'.
				$issued_rev['minor_revision'],array('controller'=>'revisions','action'=>'edit',$issued_rev['id'])).' ';


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
			 echo '<br/>(',$issued_rev['doc_status_date'],')';

		      } else {
		         echo "none";
		      }
		 ?>&nbsp;</td>
		<td>
		<?php
		     $latest_rev = null;
		     if (sizeof($doc['Revision'])>0)
		     	$latest_rev = $doc['Revision'][sizeof($doc['Revision'])-1];
		      if ($latest_rev != null) {
		      	 echo $this->Html->link($latest_rev['major_revision'].'_'.
				$latest_rev['minor_revision'],array('controller'=>'revisions','action'=>'edit',$latest_rev['id'])).' ';

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

			 echo '<br/>(',$latest_rev['doc_status_date'],')';

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
                  echo ":";
                  echo $this->Form->postLink('Minor',
			array('controller'=>'revisions',
                              'action'=>'create_new_revision',$doc['Doc']['id']),
			array(),__('Create Minor Revision?'));
		?>
		</td>
		<td class="actions">
		<!--	<?php echo $this->Html->link(__('View'), array('action' => 'view', $doc['Doc']['id'])); ?> -->
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $doc['Doc']['id'])); ?>
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
			<th><?php echo $this->Paginator->sort('facilty_id','Facility'); ?></th>
			<th><?php echo $this->Paginator->sort('doc_type_id','Type'); ?></th>
			<th><?php echo $this->Paginator->sort('doc_subtype_id','Sub-Type'); ?></th>
			<th><?php echo $this->Paginator->sort('docNo','Doc. No.'); ?></th>
			<th><?php echo $this->Paginator->sort('title','Title'); ?></th>
			<th><?php echo "Issued"; ?></th>
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
		<td>
		<?php 
		      $issued_rev = null;
		      foreach ($doc['Revision'] as $rev) {
		      	      if ($rev['doc_status_id']==2) $issued_rev = $rev;
		      }
		      if ($issued_rev != null) {
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

			 echo '<br/>(',$issued_rev['doc_status_date'],')';


		      } else {
		         echo "none";
		      }
		 ?>&nbsp;</td>

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


<?php } ?>
</div>


<!-- ****************************************************************** -->

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
     <div class='Facility_filter'>
     Select Facility
     <ul id='facility'> 
     <li> <?php echo $this->Html->link('All', array('controller' => 'docs', 'action' => 'index')); ?> </li>
     <li><?php echo $this->Html->link('HAT', array('controller' => 'docs', 'action' => 'index','facility'=>0)); ?></li>
     <li><?php echo $this->Html->link('CA', array('controller' => 'docs', 'action' => 'index','facility'=>1)); ?></li>
     <li><?php echo $this->Html->link('CF', array('controller' => 'docs', 'action' => 'index','facility'=>2)); ?></li>
     </ul>
     </div>

     <div class='Doc_type_filter'>
     Select Doc Type
     <ul>
     <li><?php echo $this->Html->link('All', array('controller' => 'docs', 'action' => 'index')); ?></li>
     <li><?php echo $this->Html->link('MSM', array('controller' => 'docs', 'action' => 'index','doc_type'=>0)); ?></li>
     <li><?php echo $this->Html->link('POL', array('controller' => 'docs', 'action' => 'index','doc_type'=>1)); ?></li>
     <li><?php echo $this->Html->link('PROC', array('controller' => 'docs', 'action' => 'index','doc_type'=>2)); ?></li>
     </ul>
     </div>

     <div class='Doc_subType_filter'>
     Select Doc Sub-Type
     <ul>
     <li><?php echo $this->Html->link('All', array('controller' => 'docs', 'action' => 'index')); ?></li>
     <li><?php echo $this->Html->link('GOV', array('controller' => 'docs', 'action' => 'index','doc_subtype'=>0)); ?></li>
     <li><?php echo $this->Html->link('FIN', array('controller' => 'docs', 'action' => 'index','doc_subtype'=>1)); ?></li>
     <li><?php echo $this->Html->link('HR', array('controller' => 'docs', 'action' => 'index','doc_subtype'=>2)); ?></li>
     <li><?php echo $this->Html->link('H&S', array('controller' => 'docs', 'action' => 'index','doc_subtype'=>3)); ?></li>
     <li><?php echo $this->Html->link('FAC', array('controller' => 'docs', 'action' => 'index','doc_subtype'=>4)); ?></li>
     </ul>
     </div>

     <button onclick='applyFilter()'>Apply Filter</button>

     <script>
     applyFilter = function() {
        facility = $('#facility').val();
        docType = $('#docType').val();
        
	newURL = $(location).attr('href')+'docType:'+docType;
	alert(newURL);
	$(document).load(newURL);
     }
     </script>


	<ul>
		<li><?php echo $this->Html->link(__('New Doc'), array('action' => 'add')); ?></li>

	</ul>
</div>
