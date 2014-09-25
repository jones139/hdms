<div class="index form">
<h1>Reports Index</h1>
<ul>
<li>	<?php echo $this->Html->link("Issued Documents",
			    array('controller'=>'reports',
                            'action'=>'recent'
			   )); ?>
</li>
<li>	<?php echo $this->Html->link("Draft Documents",
			    array('controller'=>'reports',
                            'action'=>'drafts'
			   )); ?>
</li>

</ul>
</div>

<?php
###############
# Back Button #
###############?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
	</ul>
</div>
