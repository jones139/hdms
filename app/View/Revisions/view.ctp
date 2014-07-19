<div class="revisions view">
<h2><?php echo __('Revision'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($revision['Revision']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Doc'); ?></dt>
		<dd>
			<?php echo $this->Html->link($revision['Doc']['title'], array('controller' => 'docs', 'action' => 'view', $revision['Doc']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Major Revision'); ?></dt>
		<dd>
			<?php echo h($revision['Revision']['major_revision']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Minor Revision'); ?></dt>
		<dd>
			<?php echo h($revision['Revision']['minor_revision']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($revision['User']['title'], array('controller' => 'users', 'action' => 'view', $revision['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Doc Status'); ?></dt>
		<dd>
			<?php echo $this->Html->link($revision['DocStatus']['title'], array('controller' => 'doc_statuses', 'action' => 'view', $revision['DocStatus']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Checked Out'); ?></dt>
		<dd>
			<?php echo $revision['Revision']['is_checked_out']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Has Native'); ?></dt>
		<dd>
			<?php echo h($revision['Revision']['has_native']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Has Pdf'); ?></dt>
		<dd>
			<?php echo h($revision['Revision']['has_pdf']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Has Extras'); ?></dt>
		<dd>
			<?php echo h($revision['Revision']['has_extras']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Revision'), array('action' => 'edit', $revision['Revision']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Revision'), array('action' => 'delete', $revision['Revision']['id']), array(), __('Are you sure you want to delete # %s?', $revision['Revision']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doc Statuses'), array('controller' => 'doc_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc Status'), array('controller' => 'doc_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('controller' => 'notifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('controller' => 'notifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route Lists'), array('controller' => 'route_lists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List'), array('controller' => 'route_lists', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Notifications'); ?></h3>
	<?php if (!empty($revision['Notification'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Body Text'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Revision Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($revision['Notification'] as $notification): ?>
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
	<h3><?php echo __('Related Route Lists'); ?></h3>
	<?php if (!empty($revision['RouteList'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Revision Id'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($revision['RouteList'] as $routeList): ?>
		<tr>
			<td><?php echo $routeList['id']; ?></td>
			<td><?php echo $routeList['revision_id']; ?></td>
			<td><?php echo $routeList['active']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'route_lists', 'action' => 'view', $routeList['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'route_lists', 'action' => 'edit', $routeList['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'route_lists', 'action' => 'delete', $routeList['id']), array(), __('Are you sure you want to delete # %s?', $routeList['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Route List'), array('controller' => 'route_lists', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
