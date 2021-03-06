<?php
/***************************************************************************
 *   This file is part of HDMS.
 *
 *   Copyright 2014, Graham Jones (grahamjones@physics.org)
 *
 *   HDMS is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   HDMS is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with HDMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 ****************************************************************************/

App::uses('AppModel', 'Model');
/**
 * RouteList Model
 *
 * @package       app.Model
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


	/**
	 * Find the revision number of the route $id
         */
	public function getRevisionId($id) {
	       $options = array('conditions' => array('RouteList.id' => $id),
	     	      		'fields'=>array('RouteList.revision_id')
				);
	       $rldata = $this->find('first',$options);
	       $revision_id = $rldata['RouteList']['revision_id'];
	       return $revision_id;
	}


	/* Check the status of the route list by ckecking the response from all of the approvers
	 *  (routelistentries) - checks to see if all of the approvers have responded (returns true)
	 * otherwise returns false.
	 * If the route list is complete it also sets the route list status flag to 2 (=complete)
	 */
	public function isComplete($id = null) {
	     # get a list of all the entries in this route list.
	     $options = array('conditions' => 
	                         array('RouteListEntry.route_list_id' => $id),
	     	      		'fields'=>array('RouteListEntry.id',
					        'RouteListEntry.user_id',
                                                'RouteListEntry.response_id'),
				'recursive'=>1
				);
	     $rle_list = $this->RouteListEntry->find('all', $options);

	     # check each  entry to see if it has been approved.
	     $complete = true;  
	     foreach ($rle_list as $rle) {
	        if ($rle['RouteListEntry']['response_id']==0) {
		   $complete = false;
		}
	     }
	     echo "Route list complete status = ".$complete." id=".$id;

	     # if the route list is complete, set the route list status to complete.
	     if ($complete) {
	     	$this->read(null,$id);
	     	$this->set(array('route_list_status_id'=>2));  # status 2 = complete
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
	     #
	     # if the route list is approved, set the associated revision 
	     #    status to approved.
	     $revision_id = $this->getRevisionId($id);
	     $this->Revision->read(null,$revision_id);
	     if ($this->isComplete($id)) {
	     	if ($approved) {
	     	   $this->Revision->set(array('doc_status_id'=>2,
					      'doc_status_date'=>date('Y-m-d H:i:s')
					));  # status 2 = approved
	     	} else {
	     	   $this->Revision->set(array('doc_status_id'=>3,
				'doc_status_date'=>date('Y-m-d H:i:s')));  # status 3 = rejected
 		}
	     } else {
	     	   $this->Revision->set(array('doc_status_id'=>1,'doc_status_date'=>date('Y-m-d H:i:s')));  # status 1 = waiting for approval

	     } 
	     $this->Revision->save();

	     return $approved;
	}


}
