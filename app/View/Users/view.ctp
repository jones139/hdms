<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($user['User']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email Verified'); ?></dt>
		<dd>
			<?php echo h($user['User']['email_verified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Role']['title'], array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route List Entries'), array('controller' => 'route_list_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List Entry'), array('controller' => 'route_list_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Notifications'); ?></h3>
	<?php if (!empty($user['Notification'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Body Text'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Revision Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Notification'] as $notification): ?>
		<tr>
			<td><?php echo $notification['id']; ?></td>
			<td><?php echo $notification['user_id']; ?></td>
			<td><?php echo $notification['body_text']; ?></td>
			<td><?php echo $notification['active']; ?></td>
			<td><?php echo $notification['revision_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'notifications', 'action' => 'view', $notification['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'notifications', 'action' => 'edit', $notification['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'notifications', 'action' => 'delete', $notification['id']), array(), __('Are you sure you want to delete # %s?', $notification['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Notification'), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Revisions'); ?></h3>
	<?php if (!empty($user['Revision'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Doc Id'); ?></th>
		<th><?php echo __('Major Revision'); ?></th>
		<th><?php echo __('Minor Revision'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Doc Status Id'); ?></th>
		<th><?php echo __('Has Native'); ?></th>
		<th><?php echo __('Has Pdf'); ?></th>
		<th><?php echo __('Has Extras'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Revision'] as $revision): ?>
		<tr>
			<td><?php echo $revision['id']; ?></td>
			<td><?php echo $revision['doc_id']; ?></td>
			<td><?php echo $revision['major_revision']; ?></td>
			<td><?php echo $revision['minor_revision']; ?></td>
			<td><?php echo $revision['user_id']; ?></td>
			<td><?php echo $revision['doc_status_id']; ?></td>
			<td><?php echo $revision['has_native']; ?></td>
			<td><?php echo $revision['has_pdf']; ?></td>
			<td><?php echo $revision['has_extras']; ?></td>
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
	<?php if (!empty($user['RouteListEntry'])): ?>
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
	<?php foreach ($user['RouteListEntry'] as $routeListEntry): ?>
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
