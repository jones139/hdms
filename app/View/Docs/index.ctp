<div class="docs index">
     <div class='Facility_filter'>
     Select Facility
     <ol> 
     <li><?php echo $this->Html->link('All', array('controller' => 'docs', 'action' => 'index')); ?></li>
     <li><?php echo $this->Html->link('HAT', array('controller' => 'docs', 'action' => 'index','facility'=>0)); ?></li>
     <li><?php echo $this->Html->link('CA', array('controller' => 'docs', 'action' => 'index','facility'=>1)); ?></li>
     <li><?php echo $this->Html->link('CF', array('controller' => 'docs', 'action' => 'index','facility'=>2)); ?></li>
     </ol>
     </div>

     <div class='Doc_type_filter'>
     Select Doc Type
     <ol> 
     <li><?php echo $this->Html->link('All', array('controller' => 'docs', 'action' => 'index')); ?></li>
     <li><?php echo $this->Html->link('MSM', array('controller' => 'docs', 'action' => 'index','doc_type'=>0)); ?></li>
     <li><?php echo $this->Html->link('POL', array('controller' => 'docs', 'action' => 'index','doc_type'=>1)); ?></li>
     <li><?php echo $this->Html->link('PROC', array('controller' => 'docs', 'action' => 'index','doc_type'=>2)); ?></li>
     </ol>
     </div>

	<h2><?php echo __('Documents'); ?></h2>
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
			<?php echo $this->Html->link($doc['Facility']['title'], array('controller' => 'facilities', 'action' => 'view', $doc['Facility']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($doc['DocType']['title'], array('controller' => 'doc_types', 'action' => 'view', $doc['DocType']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($doc['DocSubtype']['title'], array('controller' => 'doc_subtypes', 'action' => 'view', $doc['DocSubtype']['id'])); ?>
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
				$issued_rev['minor_revision'],array('controller'=>'revisions','action'=>'edit',$issued_rev['id']));
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
				$latest_rev['minor_revision'],array('controller'=>'revisions','action'=>'edit',$latest_rev['id']));
		      	 #echo $latest_rev['major_revision'].'_'.
			 #	$latest_rev['minor_revision'].'<br>';
		      } else {
		         echo "none";
		      }
		?> </td>
                <td> <?php
                  echo $this->Html->link('Major',
			array('controller'=>'revisions',
			      'action'=>'create_new_revision',$doc['Doc']['id'],
			      'major'=>'true'));
                  echo ":";
                  echo $this->Html->link('Minor',
			array('controller'=>'revisions',
                              'action'=>'create_new_revision',$doc['Doc']['id']));
		?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $doc['Doc']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $doc['Doc']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $doc['Doc']['id']), array(), __('Are you sure you want to delete # %s?', $doc['Doc']['id'])); ?>
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
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Doc'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Facilities'), array('controller' => 'facilities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facility'), array('controller' => 'facilities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
	</ul>
</div>
