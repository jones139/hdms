<div class="facilities view">
<h2><?php echo __('Facility'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($facility['Facility']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($facility['Facility']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Codestr'); ?></dt>
		<dd>
			<?php echo h($facility['Facility']['codestr']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Facility'), array('action' => 'edit', $facility['Facility']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Facility'), array('action' => 'delete', $facility['Facility']['id']), array(), __('Are you sure you want to delete # %s?', $facility['Facility']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Facilities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Facility'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doc'), array('controller' => 'docs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Docs'); ?></h3>
	<?php if (!empty($facility['Doc'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Facility Id'); ?></th>
		<th><?php echo __('DocType'); ?></th>
		<th><?php echo __('DocNo'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($facility['Doc'] as $doc): ?>
		<tr>
			<td><?php echo $doc['id']; ?></td>
			<td><?php echo $doc['facility_id']; ?></td>
			<td><?php echo $doc['docType']; ?></td>
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
