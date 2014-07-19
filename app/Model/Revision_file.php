<?php
App::uses('AppModel', 'Model');
/**
 * Revision Model - saved version for when cake bake overwrites it!
 *
 * @property Doc $Doc
 * @property User $User
 * @property DocStatus $DocStatus
 * @property Notification $Notification
 * @property RouteList $RouteList
 */
class Revision extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Doc' => array(
			'className' => 'Doc',
			'foreignKey' => 'doc_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DocStatus' => array(
			'className' => 'DocStatus',
			'foreignKey' => 'doc_status_id',
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
		'Notification' => array(
			'className' => 'Notification',
			'foreignKey' => 'revision_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RouteList' => array(
			'className' => 'RouteList',
			'foreignKey' => 'revision_id',
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

	public function isUploadedFile($params) {
	       //$val = array_shift($params);
	       $val = $params;
	       if ((isset($val['error']) && $val['error'] == 0) ||
	       	  (!empty($val['tmp_name']) && $val['tmp_name']!='none')) {
		  	return is_uploaded_file($val['tmp_name']);
		} else {
		  return false;
		}
	}

	public function get_folder($doc_id,$major_rev,$minor_rev) {
	       $this->logDebug("get_folder - appdir=".ROOT);
	       $folder=ROOT.'/'.'data'.'/'.$major_rev.'/'.$minor_rev;
	       return $folder;
	}


	public function save_file($tmpnam,$fname,$doc_id,$major_rev,$minor_rev) {
	       $this->logDebug("save_file - tmpnam=".$tmpnam);
	       $this->logDebug("save_file - fname=".$fname);
	       $folder = $this->get_folder($doc_id,$major_rev,$minor_rev);
	       $this->logDebug("save_file - folder=".$folder);
	       if (!is_dir($folder)) {
	          $this->logDebug("Attempting to create directory ".$folder);
	       	  if (mkdir($folder,0777,true)) {
	             $this->logDebug("created directory");
		  } else {
		     $this->logDebug("Failed to Create Directory");
		     return false;
		  }
               }
	       if (copy($tmpnam,$folder.'/'.$fname)) {
		     $this->logDebug("copied file");
		     return true;
	       } else {
		  $this->logDebug("failed to copy file");
		  return false;
               }
	       $this->logDebug("we shouldn't have got here!!!!");
	       return false;
        }

	public function save($data = NULL, $validate = true, $fieldList = Array()) {
	       if ($retval_parent = parent::save($data, $validate, $fieldList)) {

	       	       if ($this->isUploadedFile($data['Document']['submittedfile'])) {
		  	  $this->logDebug('Uploaded File');
			  print var_dump($data);
			  $filedata = $data['Document']['submittedfile'];
			  $revdata = $data['Revision'];
			  $tmpnam = $filedata['tmp_name'];
			  $fname  = $filedata['name'];
			  $minrev = $revdata['major_revision'];
			  $majrev = $revdata['minor_revision'];
			  $doc_id = $revdata['doc_id'];
			  $this->save_file($tmpnam,$fname,
					   $doc_id,
					   $majrev,$minrev);
			  return true;
	       	       } else {
	               	  $this->logDebug('File Upload Failed');
			  return false;
	       	       }
	        
	        } else {
		       return false;
		}
        }
}
