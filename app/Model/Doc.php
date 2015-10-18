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
 * Doc Model
 *
 * @package       app.Model
 * @property Facility $Facility
 * @property Revision $Revision
 */
class Doc extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Facility' => array(
			'className' => 'Facility',
			'foreignKey' => 'facility_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DocType' => array(
			'className' => 'DocType',
			'foreignKey' => 'doc_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DocSubtype' => array(
			'className' => 'DocSubtype',
			'foreignKey' => 'doc_subtype_id',
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
		'Revision' => array(
			'className' => 'Revision',
			'foreignKey' => 'doc_id',
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
	 * Return the revision ID of the issued revision of document id $id.
	 */ 
	public function getIssuedRevId($id) {
		App::import('Model','Revision');
		$revisionModel = new Revision();
	       $options = array('conditions' => array('Revision.doc_id' => $id, 'Revision.doc_status_id'=>2),
	     	      		'fields'=>array('max(Revision.id) as max_revision_id')
			  	);
	       $revdata = $revisionModel->find('first',$options);
	       #var_dump($revdata);
	       $revision_id = $revdata[0]['max_revision_id'];
	       return $revision_id;
	}

	/**
	 * Return the file path of the issued revision of document id $id.
	 */ 
	public function getIssuedFilepath($id,$filetype='pdf') {
		App::import('Model','Revision');
		$revisionModel = new Revision();
		$revision_id = $this->getIssuedRevId($id);
		echo "getIssuedFilepath(".$id.") - revision id = ".$revision_id;
		$filepath = $revisionModel->get_filepath($revision_id,$filetype);	
		return($filepath);
	}


}
