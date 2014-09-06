<div class="notifications index">
	<h2><?php echo __('Notifications'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('body_text'); ?></th>
			<th>Document</th>
			<th><?php echo $this->Paginator->sort('revision_id','Revision'); ?></th>
			<th><?php echo $this->Paginator->sort('sent_date','Date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($notifications as $notification): ?>
	<tr>
		<td><?php echo h($notification['Notification']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($notification['User']['title'], array('controller' => 'users', 'action' => 'view', $notification['User']['id'])); ?>
		</td>
		<td><?php echo h($notification['Notification']['body_text']); ?>&nbsp;</td>
		<td><?php echo h($notification['Revision']['Doc']['docNo']); ?>
                    <?php echo "<br/>".h($notification['Revision']['Doc']['title']); ?>
                </td>
		<td class="actions">
			<?php 
                            echo $notification['Revision']['major_revision'].
			          "_".
                                 $notification['Revision']['minor_revision'].
				 " ";
			    echo $this->Html->link("Review/Approve",
                            array('controller' => 'revisions', 
                                  'action' => 'edit', 
                                  $notification['Revision']['id'])); ?>
		</td>

		<td>
			<?php
			echo $notification['Notification']['sent_date'];
			?>

		<td class="actions">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $notification['Notification']['id']), array(), __('Are you sure you want to delete # %s?', $notification['Notification']['id'])); ?>
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
	  <li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
	</ul>
</div>
