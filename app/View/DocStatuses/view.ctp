<div class="docStatuses view">
<h2><?php echo __('Doc Status'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($docStatus['DocStatus']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($docStatus['DocStatus']['title']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Doc Status'), array('action' => 'edit', $docStatus['DocStatus']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Doc Status'), array('action' => 'delete', $docStatus['DocStatus']['id']), array(), __('Are you sure you want to delete # %s?', $docStatus['DocStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Doc Statuses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc Status'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Revisions'); ?></h3>
	<?php if (!empty($docStatus['Revision'])): ?>
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
	<?php foreach ($docStatus['Revision'] as $revision): ?>
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
