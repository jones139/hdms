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
