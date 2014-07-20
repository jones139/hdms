<div class="docs view">
<h2><?php echo __('Doc'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($doc['Doc']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facility'); ?></dt>
		<dd>
			<?php echo $this->Html->link($doc['Facility']['title'], array('controller' => 'facilities', 'action' => 'view', $doc['Facility']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($doc['Doc']['doc_type_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sub Type'); ?></dt>
		<dd>
			<?php echo h($doc['Doc']['doc_subtype_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('DocNo'); ?></dt>
		<dd>
			<?php echo h($doc['Doc']['docNo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($doc['Doc']['title']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Doc'), array('action' => 'edit', $doc['Doc']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Doc'), array('action' => 'delete', $doc['Doc']['id']), array(), __('Are you sure you want to delete # %s?', $doc['Doc']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Docs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Facilities'), array('controller' => 'facilities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facility'), array('controller' => 'facilities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Revisions'); ?></h3>
	<?php if (!empty($doc['Revision'])): ?>
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
	<?php foreach ($doc['Revision'] as $revision): ?>
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
