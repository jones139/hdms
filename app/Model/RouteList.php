<?php
App::uses('AppModel', 'Model');
/**
 * RouteList Model
 *
 * @property Revision $Revision
 * @property RouteListEntry $RouteListEntry
 */
class RouteList extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'revision_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'RouteListEntry' => array(
			'className' => 'RouteListEntry',
			'foreignKey' => 'route_list_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	/* Check the status of the route list by ckecking the response from all of the approvers
	 *  (routelistentries) - checks to see if all of the approvers have responded (returns true)
	 * otherwise returns false.
	 * If the route list is complete it also sets the route list status flag to 2 (=complete)
	 */
	public function isComplete($id = null) {
	     # get a list of all the entries in this route list.
	     $options = array('conditions' => array('RouteListEntry.route_list_id' => $id),
	     	      		'fields'=>array('RouteListEntry.id',
					        'RouteListEntry.user_id',
                                                'RouteListEntry.response_id'),
				'recursive'=>1
				);
	     $rle_list = $this->RouteListEntry->find('all', $options);

	     # check each  entry to see if it has been approved.
	     $complete = true;  
	     foreach ($rle_list as $rle) {
	        if ($rle['RouteListEntry']['response_id']!=0) {
		   $complete = false;
		}
	     }
	     echo "Route list complete status = ".$complete." id=".$id;

	     # if the route list is complete, set the route list status to complete.
	     if ($complete) {
	     	$this->read(null,$id);
	     	$this->set(array('route_list_status_id'=>2));  # status 2 = approved
	     	$this->save();
	     } 
	     return $complete;
	}



	/* Check the status of the route list by ckecking the response from all of the approvers
	 *  (routelistentries).
	 * If the document is approved it also changes the document_status_id in the revision record
         *   to issued status.
	 */
	public function isApproved($id = null) {
	     # get a list of all the entries in this route list.
	     $options = array('conditions' => array('RouteListEntry.route_list_id' => $id),
	     	      		'fields'=>array('RouteListEntry.id',
					        'RouteListEntry.user_id',
                                                'RouteListEntry.response_id'),
				'recursive'=>1
				);
	     $rle_list = $this->RouteListEntry->find('all', $options);
	     #echo var_dump($rle_list);

	     # check each  entry to see if it has been approved.
	     $approved = true;  
	     foreach ($rle_list as $rle) {
	        if ($rle['RouteListEntry']['response_id']!=1) {
		   $approved = false;
		}
	     }

	     # if the route list is approved, set the associated revision status to approved.
	     if ($approved) {
	     	# find the revision number of the route list that has been approved.
	     	$options = array('conditions' => array('RouteList.id' => $id),
	     	      		'fields'=>array('RouteList.revision_id')
				);
	     	$rldata = $this->find('first',$options);
	     	$revision_id = $rldata['RouteList']['revision_id'];

	     	$this->Revision->read(null,$revision_id);
	     	$this->Revision->set(array('doc_status_id'=>2));  # status 2 = approved
		#var_dump($this->Revision->data);
	     	$this->Revision->save();
	     } 

	     return $approved;
	}

}
