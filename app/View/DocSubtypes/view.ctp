<div class="docSubtypes view">
<h2><?php echo __('Doc Subtype'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($docSubtype['DocSubtype']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($docSubtype['DocSubtype']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($docSubtype['DocSubtype']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Doc Subtype'), array('action' => 'edit', $docSubtype['DocSubtype']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Doc Subtype'), array('action' => 'delete', $docSubtype['DocSubtype']['id']), array(), __('Are you sure you want to delete # %s?', $docSubtype['DocSubtype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Doc Subtypes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc Subtype'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Docs'); ?></h3>
	<?php if (!empty($docSubtype['Doc'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Facility Id'); ?></th>
		<th><?php echo __('Doc Type Id'); ?></th>
		<th><?php echo __('Doc Subtype Id'); ?></th>
		<th><?php echo __('DocNo'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($docSubtype['Doc'] as $doc): ?>
		<tr>
			<td><?php echo $doc['id']; ?></td>
			<td><?php echo $doc['facility_id']; ?></td>
			<td><?php echo $doc['doc_type_id']; ?></td>
			<td><?php echo $doc['doc_subtype_id']; ?></td>
			<td><?php echo $doc['docNo']; ?></td>
			<td><?php echo $doc['title']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'docs', 'action' => 'view', $doc['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'docs', 'action' => 'edit', $doc['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'docs', 'action' => 'delete', $doc['id']), array(), __('Are you sure you want to delete # %s?', $doc['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
