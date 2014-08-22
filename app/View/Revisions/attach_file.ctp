<div class="revisions form">
<?php 
      ## FIXME - this does not add a PDF parameter to the URL, so uploads as a native file!!!!
        echo $this->Form->create('Revision', array('type'=>'file', 'action'=>'attach_file','pdf'=>$pdf)); 
?>
	<fieldset>
		<legend><?php 
		if ($pdf)
		   echo __('Attach PDF file '); 
		else
		   echo __('Attach Native file '); 
		echo __('for revision '.$this->request->data['Revision']['major_revision'].'_'.$this->request->data['Revision']['minor_revision'].' of document "'.$this->request->data['Doc']['title'].'" ('.$this->request->data['Doc']['docNo'].')'); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('doc_id',array('type'=>'text','hidden'=>'true'));
		echo $this->Form->hidden('major_revision');
		echo $this->Form->hidden('minor_revision');
		echo $this->Form->file('Document.submittedfile',array('label'=>'Select New File'));
		
	?>
	</fieldset>
<?php 
      echo $this->Form->submit('Upload File', array('after'=>$this->Html->link(__('Cancel'), array('controller' => 'revisions', 
      	   				   	'action' => 'edit',
						$this->request->data['Revision']['id']))));
      echo $this->Form->end(); ?>

</div>
