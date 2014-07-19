<div class="revisions form">
<?php 
      echo $this->Form->create('Revision', array('type'=>'file', 'action'=>'upload_file')); 
?>
	<fieldset>
		<legend><?php echo __('Upload file for revision '.$this->request->data['Revision']['major_revision'].'_'.$this->request->data['Revision']['minor_revision'].' of document "'.$this->request->data['Doc']['title'].'" ('.$this->request->data['Doc']['docNo'].')'); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('doc_id',array('type'=>'text','hidden'=>'true'));
		echo $this->Form->hidden('major_revision');
		echo $this->Form->hidden('minor_revision');
		echo $this->Form->label('fname','Current File is: '.$this->request->data['Revision']['filename']);
		echo $this->Form->file('Document.submittedfile',array('label'=>'Select New File'));
		
	?>
	</fieldset>
<?php 
      echo $this->Form->submit('Upload File', array('after'=>$this->Html->link(__('Cancel'), array('controller' => 'revisions', 
      	   				   	'action' => 'edit',
						$this->request->data['Revision']['id']))));
      echo $this->Form->end(); ?>
<pre>
<?php var_dump($this->request->data); ?>
</pre>

</div>
