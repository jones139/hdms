<div class="draft form">
<?php 
      if (isset($data)) {
      	 echo "<h1>Draft Documents</h1>";
      	 echo "<table>";
      	 echo "<tr>";
      	 echo "<th>Doc No</th><th>Title</th><th>Revision</th><th>Date</th><th>View</th>";
      	 echo "</tr>";
      	 foreach($data as $rev) {
      	    echo "<tr>";
	    echo "<td>".$rev['Doc']['docNo']."</td>";
	    echo "<td>".$rev['Doc']['title']."</td>";
      	    echo "<td>".$rev['Revision']['major_revision'].'_'.$rev['Revision']['minor_revision']."</td>";
	    echo "<td>".$rev['Revision']['doc_status_date']."</td>";
	    echo "<td>".$this->Html->link("View",
			    array('controller'=>'revisions',
                            'action'=>'edit',$rev['Revision']['id']),
                            array('class'=>'button')
			   ).'</td>';

	    echo "</tr>";
      	}
      	echo "</table>";
      }

?>
</div>
<div class="actions">
<?php
###############
# Back Button #
###############
echo $this->Html->link('Back',
      array('controller'=>'docs','action'=>'index')); ?>
</div>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Docs'), array('controller' => 'docs', 'action' => 'index')); ?> </li>
	</ul>
</div>
