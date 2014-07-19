<div class="routeListEntries index">
	<h2><?php echo __('Route List Entries'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('route_list_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('response_id'); ?></th>
			<th><?php echo $this->Paginator->sort('response_date'); ?></th>
			<th><?php echo $this->Paginator->sort('response_comment'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($routeListEntries as $routeListEntry): ?>
	<tr>
		<td><?php echo h($routeListEntry['RouteListEntry']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($routeListEntry['RouteList']['id'], array('controller' => 'route_lists', 'action' => 'view', $routeListEntry['RouteList']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($routeListEntry['User']['title'], array('controller' => 'users', 'action' => 'view', $routeListEntry['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($routeListEntry['Response']['title'], array('controller' => 'responses', 'action' => 'view', $routeListEntry['Response']['id'])); ?>
		</td>
		<td><?php echo h($routeListEntry['RouteListEntry']['response_date']); ?>&nbsp;</td>
		<td><?php echo h($routeListEntry['RouteListEntry']['response_comment']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $routeListEntry['RouteListEntry']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $routeListEntry['RouteListEntry']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $routeListEntry['RouteListEntry']['id']), array(), __('Are you sure you want to delete # %s?', $routeListEntry['RouteListEntry']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Route List Entry'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Route Lists'), array('controller' => 'route_lists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List'), array('controller' => 'route_lists', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Responses'), array('controller' => 'responses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Response'), array('controller' => 'responses', 'action' => 'add')); ?> </li>
	</ul>
</div>
