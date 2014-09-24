<div class="docs form">
<h1>Edit Document Data</h1>
<?php echo $this->Form->create('Doc'); ?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('facility_id',
		     array('div'=>'floatleft'));
		echo '<div class="floatleft">/</div>';
		echo $this->Form->input('doc_type_id',
		     array('options'=>$doc_types,
		           'div'=>'floatleft'));
		echo '<div class="floatleft">/</div>';
		echo $this->Form->input('doc_subtype_id',
		     array('options'=>$doc_subtypes,
		     'div'=>'floatleft'));
		echo $this->Form->input('docNo',
		     array('div'=>'floatleft'));
		echo $this->Form->input('title',
		     array());
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

<h1>Document Revision History</h1>
<table>
<tr>
<td>Rev</td>
<td>Status</td>
<td>Date</td>
<td>User</td>
<td>Notes</td>
</tr>
<?php
   foreach ($this->request->data['Revision'] as $rev) {
      echo "<tr>";
      echo "<td>".$rev['major_revision'].'_'.$rev['minor_revision']."</td>";
      echo "<td>".$rev['doc_status_id']."</td>";
      echo "<td>".$rev['doc_status_date']."</td>";
      echo "<td>".$rev['user_id']."</td>";
      echo "<td>".$rev['comment']."</td>";
      echo "</tr>";
   }
?>
</table>

</div>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Docs'), array('action' => 'index')); ?></li>
	</ul>
</div>
