<div class="docs form">
<?php echo $this->Form->create('Doc'); ?>
	<fieldset>
		<legend><?php echo __('Edit Doc'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('facility_id');
		echo $this->Form->input('doc_type_id',
		     array('options'=>$doc_types));
		echo $this->Form->input('doc_subtype_id',
		     array('options'=>$doc_subtypes));
		echo $this->Form->input('docNo');
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Docs'), array('action' => 'index')); ?></li>
	</ul>
</div>
