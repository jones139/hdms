<div class="responses view">
<h2><?php echo __('Response'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($response['Response']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($response['Response']['title']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Response'), array('action' => 'edit', $response['Response']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Response'), array('action' => 'delete', $response['Response']['id']), array(), __('Are you sure you want to delete # %s?', $response['Response']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Responses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Response'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route List Entries'), array('controller' => 'route_list_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List Entry'), array('controller' => 'route_list_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Route List Entries'); ?></h3>
	<?php if (!empty($response['RouteListEntry'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Route List Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Response Id'); ?></th>
		<th><?php echo __('Response Date'); ?></th>
		<th><?php echo __('Response Comment'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($response['RouteListEntry'] as $routeListEntry): ?>
		<tr>
			<td><?php echo $routeListEntry['id']; ?></td>
			<td><?php echo $routeListEntry['route_list_id']; ?></td>
			<td><?php echo $routeListEntry['user_id']; ?></td>
			<td><?php echo $routeListEntry['response_id']; ?></td>
			<td><?php echo $routeListEntry['response_date']; ?></td>
			<td><?php echo $routeListEntry['response_comment']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'route_list_entries', 'action' => 'view', $routeListEntry['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'route_list_entries', 'action' => 'edit', $routeListEntry['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'route_list_entries', 'action' => 'delete', $routeListEntry['id']), array(), __('Are you sure you want to delete # %s?', $routeListEntry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Route List Entry'), array('controller' => 'route_list_entries', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
