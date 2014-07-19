<div class="routeListEntries view">
<h2><?php echo __('Route List Entry'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($routeListEntry['RouteListEntry']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Route List'); ?></dt>
		<dd>
			<?php echo $this->Html->link($routeListEntry['RouteList']['id'], array('controller' => 'route_lists', 'action' => 'view', $routeListEntry['RouteList']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($routeListEntry['User']['title'], array('controller' => 'users', 'action' => 'view', $routeListEntry['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Response'); ?></dt>
		<dd>
			<?php echo $this->Html->link($routeListEntry['Response']['title'], array('controller' => 'responses', 'action' => 'view', $routeListEntry['Response']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Response Date'); ?></dt>
		<dd>
			<?php echo h($routeListEntry['RouteListEntry']['response_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Response Comment'); ?></dt>
		<dd>
			<?php echo h($routeListEntry['RouteListEntry']['response_comment']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Route List Entry'), array('action' => 'edit', $routeListEntry['RouteListEntry']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Route List Entry'), array('action' => 'delete', $routeListEntry['RouteListEntry']['id']), array(), __('Are you sure you want to delete # %s?', $routeListEntry['RouteListEntry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Route List Entries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List Entry'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route Lists'), array('controller' => 'route_lists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List'), array('controller' => 'route_lists', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Responses'), array('controller' => 'responses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Response'), array('controller' => 'responses', 'action' => 'add')); ?> </li>
	</ul>
</div>
