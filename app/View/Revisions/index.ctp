<div class="revisions index">
	<h2><?php echo __('Revisions'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('doc_id'); ?></th>
			<th><?php echo $this->Paginator->sort('major_revision'); ?></th>
			<th><?php echo $this->Paginator->sort('minor_revision'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('doc_status_id'); ?></th>
			<th><?php echo $this->Paginator->sort('route_list_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($revisions as $revision): ?>
	<tr>
		<td><?php echo h($revision['Revision']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($revision['Doc']['title'], array('controller' => 'docs', 'action' => 'view', $revision['Doc']['id'])); ?>
		</td>
		<td><?php echo h($revision['Revision']['major_revision']); ?>&nbsp;</td>
		<td><?php echo h($revision['Revision']['minor_revision']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($revision['User']['id'], array('controller' => 'users', 'action' => 'view', $revision['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($revision['DocStatus']['title'], array('controller' => 'doc_statuses', 'action' => 'view', $revision['DocStatus']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($revision['RouteList']['id'], array('controller' => 'route_lists', 'action' => 'view', $revision['RouteList']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $revision['Revision']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $revision['Revision']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $revision['Revision']['id']), array(), __('Are you sure you want to delete # %s?', $revision['Revision']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Revision'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doc Statuses'), array('controller' => 'doc_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc Status'), array('controller' => 'doc_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route Lists'), array('controller' => 'route_lists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List'), array('controller' => 'route_lists', 'action' => 'add')); ?> </li>
	</ul>
</div>
