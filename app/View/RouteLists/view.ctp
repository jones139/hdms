<div class="routeLists view">
<h2><?php echo __('Route List'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($routeList['RouteList']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Revision'); ?></dt>
		<dd>
			<?php echo $this->Html->link($routeList['Revision']['id'], array('controller' => 'revisions', 'action' => 'view', $routeList['Revision']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Route List'), array('action' => 'edit', $routeList['RouteList']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Route List'), array('action' => 'delete', $routeList['RouteList']['id']), array(), __('Are you sure you want to delete # %s?', $routeList['RouteList']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Route Lists'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route List Entries'), array('controller' => 'route_list_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List Entry'), array('controller' => 'route_list_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Revisions'); ?></h3>
	<?php if (!empty($routeList['Revision'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Doc Id'); ?></th>
		<th><?php echo __('Major Revision'); ?></th>
		<th><?php echo __('Minor Revision'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Doc Status Id'); ?></th>
		<th><?php echo __('Route List Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($routeList['Revision'] as $revision): ?>
		<tr>
			<td><?php echo $revision['id']; ?></td>
			<td><?php echo $revision['doc_id']; ?></td>
			<td><?php echo $revision['major_revision']; ?></td>
			<td><?php echo $revision['minor_revision']; ?></td>
			<td><?php echo $revision['user_id']; ?></td>
			<td><?php echo $revision['doc_status_id']; ?></td>
			<td><?php echo $revision['route_list_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'revisions', 'action' => 'view', $revision['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'revisions', 'action' => 'edit', $revision['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'revisions', 'action' => 'delete', $revision['id']), array(), __('Are you sure you want to delete # %s?', $revision['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Route List Entries'); ?></h3>
	<?php if (!empty($routeList['RouteListEntry'])): ?>
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
	<?php foreach ($routeList['RouteListEntry'] as $routeListEntry): ?>
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
