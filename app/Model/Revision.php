<?php
App::uses('AppModel', 'Model');
/**
 * Revision Model
 *
 * @package       app.Model
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
	       	       if (isset($data['Document'])) {
		          if ($this->isUploadedFile($data['Document']['submittedfile'])) {
		  	     $this->logDebug('Uploaded File');
			     print var_dump($data);
			     $filedata = $data['Document']['submittedfile'];
			     $revdata = $data['Revision'];
			     $tmpnam = $filedata['tmp_name'];
			     $fname  = $filedata['name'];
			     $majrev = $revdata['major_revision'];
			     $minrev = $revdata['minor_revision'];
			     $doc_id = $revdata['doc_id'];
			     $this->save_file($tmpnam,$fname,
					   $doc_id,
					   $majrev,$minrev);
	               	     $this->logDebug('Save with file upload ok.');
			     return true;
                          } else {
	               	     $this->logDebug('Document set, but it is not a file?????.');
			     return true;
			  }
	       	       } else {
	               	  $this->logDebug('Save without file upload.');
			  return true;
	       	       }
	        
	        } else {
		       return false;
		}
        }


	/**
	* Return the folder used to store files for document $doc_id,
	* major revision $major_rev and minor revision $minor_rev.
	*/
	public function get_folder($doc_id,$major_rev,$minor_rev) {
	       $this->logDebug("get_folder - appdir=".ROOT);
	       $folder=ROOT.'/'.'data'.'/'.$doc_id.'/'.$major_rev.'/'.$minor_rev;
	       return $folder;
	}


	public function get_filepath($id = NULL) {
		# Populate $this->data with data from revision.id=$id
		$this->read(null, $id);
		$folder = $this->get_folder(
			$this->data['Revision']['doc_id'],
			$this->data['Revision']['major_revision'],
			$this->data['Revision']['minor_revision']);
		$fpath = $folder.'/'.$this->data['Revision']['filename'];
		echo "fpath=".$fpath."<br/>";
		return $fpath;
 	}

	public function checkout_file($id = NULL,$authUserData) {
	       	$this->id = $id;
		if (!$this->exists()) {
		   return false;
		}
		# Populate $this->data with data from revision.id=$id
		$this->read(null, $id);
		$fpath = $this->get_filepath($id);
		# Update the revision data record.
		echo "authuserdata->id=".$authUserData['id'];
		$this->set(array(
			'is_checked_out' => true,
			'check_out_user_id' => $authUserData['id'],      
			'check_out_date' => date('Y-m-d H:i:s')
		));
		# And save it
		$this->save();

		# return the path to the checked out file.
		return $fpath;		
	}


	public function cancel_checkout_file($id = NULL) {
	       	$this->id = $id;
		if (!$this->exists()) {
		   return false;
		}
		# Populate $this->data with data from revision.id=$id
		$this->read(null, $id);

		# Update the revision data record.
		$this->set(array(
			'is_checked_out' => false,
		));
		# And save it
		$this->save();

		return true;		
	}


	/* Attach a file to a revision that does not currently have a native
	* file attached
	*/
	public function attach_file($data = NULL, 
	       			    $authUserData = NULL, 
				    $validate = true) {
	       if ($this->isUploadedFile($data['Document']['submittedfile'])) {
		  	  $this->logDebug('Uploaded File');
			  #print var_dump($data);
			  $filedata = $data['Document']['submittedfile'];
			  $revdata = $data['Revision'];
			  $tmpnam = $filedata['tmp_name'];
			  $fname  = $filedata['name'];
			  $majrev = $revdata['major_revision'];
			  $minrev = $revdata['minor_revision'];
			  $doc_id = $revdata['doc_id'];
			  $this->save_file($tmpnam,$fname,
					   $doc_id,
					   $majrev,$minrev);
 			  $this->read(null, $data['Revision']['id']);
			  $this->set(array(
				'filename' => $fname,
				'has_native' => true,
				'native_file_date' => date('Y-m-d H:i:s'),
				'is_checked_out' => false,
				'user_id' => $authUserData['id']
			  ));
			  $this->save();
			  return true;
	       } else {
	               	  $this->logDebug('File Upload Failed');
			  return false;
	       }
	   } 


	public function checkin_file($data = NULL, $authUserData = NULL, $validate = true, $fieldList = Array()) {
	       if ($this->isUploadedFile($data['Document']['submittedfile'])) {
		  	  $this->logDebug('Uploaded File');
			  print var_dump($data);
			  $filedata = $data['Document']['submittedfile'];
			  $revdata = $data['Revision'];
			  $tmpnam = $filedata['tmp_name'];
			  $fname  = $filedata['name'];
			  $majrev = $revdata['major_revision'];
			  $minrev = $revdata['minor_revision'];
			  $doc_id = $revdata['doc_id'];
			  $this->save_file($tmpnam,$fname,
					   $doc_id,
					   $majrev,$minrev);
 			  $this->read(null, $data['Revision']['id']);
			  $this->set(array(
				'filename' => $fname,
				'has_native' => true,
				'native_file_date' => date('Y-m-d H:i:s'),
				'is_checked_out' => false,
				'user_id' => $authUserData['id']
			  ));
			  $this->save();
			  return true;
	       } else {
	               	  $this->logDebug('File Upload Failed');
			  return false;
	       }
	   } 


/**
 * create_new_revision of document $docid.  If a named parameter 'major' is set, it creates
 *   a major revision, otherwise it creates a minor revision.
 *
 * @var $docid - the id of the document for which a new revision is required.
 */

    public function create_new_revision($docid = null,$major=false) {
         # Retrieve all revisions for the required document, 
	 #   then select the latest one as lastrev.
         $revs = $this->find('all',array('conditions'=>array('doc_id'=>$docid)));
	 if (sizeof($revs)>0) {
	    $lastrev = $revs[sizeof($revs)-1];
	    $lastrev_id = $lastrev['Revision']['id'];
         }
	 else
	    $lastrev = -1;

	 #var_dump($lastrev);

	 if ($lastrev>=0) {
       	    # create the new revision
	    $this->create(); 
	    $lastrev['Revision']['id']=null;
	    if ($major) {
	       $lastrev['Revision']['major_revision']+=1;
	       $lastrev['Revision']['minor_revision']=1;
            } else
	       $lastrev['Revision']['minor_revision']+=1;
	    $lastrev['Revision']['doc_status_id']=0;
	    $this->save($lastrev);
	    $newrev_id = $this->getInsertID();
	    if ($lastrev['Revision']['has_native']) {
	       $folder = $this->get_folder($lastrev['Revision']['doc_id'],
					   $lastrev['Revision']['major_revision'],
					   $lastrev['Revision']['minor_revision']);
	       if (!is_dir($folder)) {
	          $this->logDebug("Attempting to create directory ".$folder);
	       	  if (mkdir($folder,0777,true)) {
	             $this->logDebug("created directory");
		  } else {
		     $this->logDebug("Failed to Create Directory");
		     return false;
		  }
               }

	       copy($this->get_filepath($lastrev_id),
		    $this->get_filepath($newrev_id));	       
	    }
   	 } else {
	    # there was no previous revision, so create one from scratch.
	    # create the new revision
	    $this->create(); 
	    $this->save();
	    $newrev_id = $this->getInsertID();
            $newrev = $this->find('all',array('conditions'=>array('Revision.id'=>$newrev_id)));
	    $newrev['Revision']['doc_id']=$docid;
	    $newrev['Revision']['major_revision']=1;
	    $newrev['Revision']['minor_revision']=1;
	    $newrev['Revision']['has_native']=false;
	    $this->save($newrev);
	 }


	 return $revs;
    	   
    }


    /**
     * has_active_routelist()
     * returns 0 if this revision has no active route list,
     * otherwise returns the ID of the active route list.
     */ 
    public function has_active_routelist($id) {
       echo "<pre> has_active_route_list - ".var_dump($this)."</pre>";
    }

    public function setApproved($id) {
	$this->read(null, $id);
	$this->set(array('doc_status_id',2));
	$this->save();
    }

}
