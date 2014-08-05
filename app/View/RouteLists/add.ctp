<div class="routeLists form">
<h3>Route List</h3>
<p> Route List for Revision 
   <?php echo $data['Revision']['major_revision'];
         echo "-";
	 echo $data['Revision']['minor_revision'];
   ?>
   of document 
   <?php echo $data['Revision']['Doc']['docNo']; ?>
   (
   <?php echo $data['Revision']['Doc']['title']; ?>
   )
</p>
<?php
  if (!$data['RouteListEntry']) {
    echo "Empty Route List";
  } else {
    foreach ($data['RouteListEntry'] as $rlEntry) {
       echo "entry<br>";
    }
  }
  echo $this->Html->link(__('Add Approver'), 
  array('controller'=>'route_lists','action' => 'add_approver',$data['RouteList']['id']));
?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Route Lists'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Revisions'), array('controller' => 'revisions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Revision'), array('controller' => 'revisions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Route List Entries'), array('controller' => 'route_list_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Route List Entry'), array('controller' => 'route_list_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>
