<div class="docs index">
	<h2><?php echo __('Docs'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('facility_id'); ?></th>
			<th><?php echo $this->Paginator->sort('docType'); ?></th>
			<th><?php echo $this->Paginator->sort('docNo'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($docs as $doc): ?>
	<tr>
		<td><?php echo h($doc['Doc']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($doc['Facility']['title'], array('controller' => 'facilities', 'action' => 'view', $doc['Facility']['id'])); ?>
		</td>
		<td><?php echo h($doc['Doc']['docType']); ?>&nbsp;</td>
		<td><?php echo h($doc['Doc']['docNo']); ?>&nbsp;</td>
		<td><?php echo h($doc['Doc']['title']); ?>&nbsp;</td>
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
