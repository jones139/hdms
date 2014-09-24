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

	/**
	 * Save the file $tmpname to revision number $rev_id as file type 
	 * $filetype (pdf,native,extras).
         * Does not alter the revision record in the database.
	 */
	public function save_file($tmpnam,$rev_id,$filetype='pdf') {
	       $this->logDebug("save_file - tmpnam=".$tmpnam);
	       $folder = $this->get_folder($rev_id);
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
	       $fpath = $this->get_filepath($rev_id,$filetype);
	       if (copy($tmpnam,$fpath)) {
		     $this->logDebug("copied file");
		     return true;
	       } else {
		  $this->logDebug("failed to copy file");
		  return false;
               }
	       $this->logDebug("we shouldn't have got here!!!!");
	       return false;
        }

	/**
	 * save method.
	 * I the data provided includes an uploaded file, process it.
	 */
	/*	public function save($data = NULL, $validate = true, $fieldList = Array()) {
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
			     $this->save_file($tmpnam,$revdata['id']);
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
	*/

	/**
	* Return the folder used to store files for revision $rev_id,
	*/
	public function get_folder($rev_id) {
	  //$this->id = $rev_id;
	  $data = $this->read(null,$rev_id)['Revision'];
	  $doc_id = $data['doc_id'];
	  $major_rev = $data['major_revision'];
	  $minor_rev = $data['minor_revision'];
	  $this->logDebug("get_folder - appdir=".ROOT);
	  $folder=ROOT.'/'.'data'.'/'.$doc_id.'/'.$major_rev.'/'.$minor_rev;
	  $this->logDebug("get_folder - folder=".$folder);
	  return $folder;
	}


	/**
	 * get_filepath($id,$filetype)
	 * returns the path to the file of type $filetype (extras,pdf,native)
	 * associated with revision number $id
	 */
	public function get_filepath($id = NULL,$filetype='pdf') {
	  // populate the $this->data arra with revision $id data.
	  $this->read(null,$id);
	  $folder = $this->get_folder($id);
	  if ($filetype=='native') { 
	    $fpath = $folder.'/'.$this->data['Revision']['filename'];
	  } elseif ($filetype=='pdf') {
	    $fpath = $folder.'/'.$this->data['Revision']['filename'].'.pdf';
	  } elseif ($filetype=='extras') {
	    $fpath = $folder.'/'.$this->data['Revision']['filename'].'.zip';
	  } else {
	    $this->logDebug("Revision->get_filepath() - Invalid file type ".$filetype.".");
	  }
	  return $fpath;
 	}

	/**
	 * Sets the revision status to checked_out to make it visible
	 * to other users that someone is editing the file.
	 */
	public function checkout_file($id = NULL,$authUserData) {
	       	$this->id = $id;
		if (!$this->exists()) {
		   return false;
		}
		// Populate $this->data with data from revision.id=$id
		  $this->id = $id;
		  $fpath = $this->get_filepath($id,'native');  // native file
		// Update the revision data record.
		echo "authuserdata->id=".$authUserData['id'];
		$this->set(array(
				 'id'=>$id,
			'is_checked_out' => true,
			'check_out_user_id' => $authUserData['id'],      
			'check_out_date' => date('Y-m-d H:i:s')
		));
		// And save it
		$this->save();

		// return the path to the checked out file.
		return $fpath;		
	}


	/**
	 * Cancel  a file checkout on revision id $id
	 */
	public function cancel_checkout_file($id = NULL) {
	       	$this->id = $id;
		if (!$this->exists()) {
		   return false;
		}
		// Populate $this->data with data from revision.id=$id
		$this->read(null, $id);
		// Update the revision data record.
		$this->set(array(
			'is_checked_out' => false,
				 ));
		// And save it
		$this->save();
		return true;		
	}


	/* Attach a native file to a revision that does not currently have 
	 * a native file attached.
	*/
	public function attach_file($data = NULL, 
	       			    $authUserData = NULL, 
				    $validate = true) {
	       if ($this->isUploadedFile($data['Document']['submittedfile'])) {
		  	  $this->logDebug('Uploaded File');
			  $filedata = $data['Document']['submittedfile'];
			  $revdata = $data['Revision'];
			  $tmpnam = $filedata['tmp_name'];
			  $fname  = $filedata['name'];
			  $majrev = $revdata['major_revision'];
			  $minrev = $revdata['minor_revision'];
			  $doc_id = $revdata['doc_id'];
			  $this->id = $data['Revision']['id'];
			  // Update revision record to reflect new file.
			  // Note that has_pdf is set to false because adding
			  // a new native file invalidates any current pdf
			  // because it is now out of date so needs to be
			  // re-generated.
			  $this->set(array(
					   'filename' => $fname,
					   'has_native' => true,
					   'native_date' => date('Y-m-d H:i:s'),
					   'is_checked_out' => false,
					   'has_pdf' => false, 
					   'user_id' => $authUserData['id'],
					   'check_out_user_id' => $authUserData['id']
					   ));
			  $this->save();
			  $this->save_file($tmpnam,$revdata['id'],'native');
			  return true;
	       } else {
	               	  $this->logDebug('File Upload Failed');
			  return false;
	       }
	   } 


	/* Attach a PDF file to a revision 
	*/
	public function attach_pdf($data = NULL, 
	       			    $authUserData = NULL, 
				    $validate = true) {
	       if ($this->isUploadedFile($data['Document']['submittedfile'])) {
		  	  $this->logDebug('Uploaded File');
			  $filedata = $data['Document']['submittedfile'];
			  $revdata = $data['Revision'];
			  $tmpnam = $filedata['tmp_name'];
			  $fname  = $revdata['filename']; // Use native file name.
			  $majrev = $revdata['major_revision'];
			  $minrev = $revdata['minor_revision'];
			  $doc_id = $revdata['doc_id'];
			  $this->save_file($tmpnam,$revdata['id'],'pdf');
			  $this->id = $data['Revision']['id'];
 			  //$this->read(null, $data['Revision']['id']);
			  // Update revision record to reflect new file.
			  $this->set(array(
					   'has_pdf' => true, 
					   'pdf_date' => date('Y-m-d H:i:s'),
					   'user_id' => $authUserData['id'],
					   ));
			  $this->save();
			  return true;
	       } else {
	               	  $this->logDebug('File Upload Failed');
			  return false;
	       }
	   } 

	/* Attach a Extras (zip) file to a revision 
	*/
	public function attach_extras($data = NULL, 
	       			    $authUserData = NULL, 
				    $validate = true) {
	       if ($this->isUploadedFile($data['Document']['submittedfile'])) {
		  	  $this->logDebug('Uploaded File');
			  $filedata = $data['Document']['submittedfile'];
			  $revdata = $data['Revision'];
			  $tmpnam = $filedata['tmp_name'];
			  $fname  = $revdata['filename']; // Use native file name.
			  $majrev = $revdata['major_revision'];
			  $minrev = $revdata['minor_revision'];
			  $doc_id = $revdata['doc_id'];
			  $this->save_file($tmpnam,$revdata['id'],'extras');
			  $this->id = $data['Revision']['id'];
			  // Update revision record to reflect new file.
			  $this->set(array(
					   'has_extras' => true, 
					   'extras_date' => date('Y-m-d H:i:s'),
					   'user_id' => $authUserData['id'],
					   ));
			  $this->save();
			  return true;
	       } else {
	               	  $this->logDebug('File Upload Failed');
			  return false;
	       }
	   } 


	/*
	 * checkin_file()
	 * Receive an uploaded file, save it in the appropriate place
	 * and update the revision database record to reflect the
	 * newly attached file.
	 * Expects $data['Revision']['id'] to be the revision id to which
	 * the file is to be associated.
	 */
	public function checkin_file($data = NULL, 
	       			     $authUserData = NULL, 
				     $validate = true, 
				     $fieldList = Array()) {
	  if ($this->isUploadedFile($data['Document']['submittedfile'])) {
	    $this->logDebug('Uploaded File');
	    $filedata = $data['Document']['submittedfile'];
	    $revdata = $data['Revision'];
	    $tmpnam = $filedata['tmp_name'];
	    $fname  = $filedata['name'];			  
	    $majrev = $revdata['major_revision'];
	    $minrev = $revdata['minor_revision'];
	    $doc_id = $revdata['doc_id'];
	    $this->read(null, $data['Revision']['id']);
	    $this->set(array(
			     'id'=>$data['Revision']['id'],
			     'filename' => $fname,
			     'has_native' => true,
			     'native_date' => date('Y-m-d H:i:s'),
			     'is_checked_out' => false,
			     'has_pdf' => false,
			     'user_id' => $authUserData['id'],
			     'check_out_user_id' => $authUserData['id']
			     ));
	    $this->save();
	    $this->save_file($tmpnam,$revdata['id'],'native');
	    return true;
	  } else {
	    $this->logDebug('File Upload Failed');
	    return false;
	  }
	} 
	
	
	/**
	 * set_pdf - set the has_pdf field of revision $id to value $value.
	 */
	public function set_pdf($id=null,$value=false) {
	  $this->id = $id;
	  $this->data['Revision']['has_pdf'] = $value;
	  $this->save();
	}

	/**
	 * Attempt to generate a PDF version of the file associated
	 *  with revision id $id.   Uses the external 'pdfgen' web service
	 *  to do this.
	 */
	public function generate_pdf($id = null) {
	  $this->logDebug("generate_pdf, id=".$id);
	  $this->id = $id;
	  if (!$this->exists()) {
	    $this->logDebug("generate_pdf, id=".$id." not found - exiting.");
	    return false;
	  }

	  // Get PDF Generator settings from the database
	  App::import('Model','Setting');
	  $SettingsModel = new Setting();
	  $settings = $SettingsModel->findById(1)['Setting'];
	  $pdf_url = $settings['pdf_url'];
	  $pdf_user = $settings['pdf_user'];
	  $pdf_passwd = $settings['pdf_passwd'];
	  
	  
	  // Submit file to an external pdf generator service using curl.
	  $ltmpfilename = $this->get_filepath($id,'native');
	  $this->logDebug("generate_pdf, ltmpfilename=".$ltmpfilename);
	  $this->logDebug("generate_pdf, pdf_url=".$pdf_url);
	  $postData = array('file'=>'@'.$ltmpfilename,'submit'=>'True'); 
	  $ch = curl_init(); 
	  curl_setopt($ch, CURLOPT_URL,$pdf_url); 
	  curl_setopt($ch, CURLOPT_POST,1); 
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, True); 
	  $result=curl_exec ($ch); 
	  curl_close ($ch); 
	  
	  if ($result == False) {
	    $this->logDebug("Error from PDF creation web service.");
	    $this->set_pdf($id,false);
	    return(false);
	  }
	  
	  // The result contains a URL to the PDF file.
	  // Extract the 'href' from the html using regular expression
	  // from http://stackoverflow.com/questions/5397531/parsing-html-source-to-extract-anchor-and-link-tags-href-value
	  preg_match_all('/href=[\'"]?([^\s\>\'"]*)[\'"\>]/', $result, $matches);
	  $hrefs = ($matches[1] ? $matches[1] : false);
	  $this->logDebug("generate_pdf, href=".$hrefs[0]);

	  // Now use CURL to download the PDF file.
	  $ch = curl_init(); 
	  curl_setopt($ch, CURLOPT_URL,$hrefs[0]); 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, True); 
	  $result=curl_exec ($ch); 
	  curl_close ($ch); 
	  if ($result == false) {
	    $this->logDebug("Error downloading pdf from PDF creation web service.");
	    $this->set_pdf($id,false);
	    return(false);
	  }
	  
	  // Save result to PDF file in correct place
	  // copy temporary file to DATADIR and give it the correct suffix.
	  $pdfFname = $this->get_filepath($id,'pdf');
	  $this->logDebug("saving pdf to ".$pdfFname);
	  $lfhandler = fopen ($pdfFname, "w");
	  if ($lfhandler == False) {
	    $this->logDebug("Error opening file ".$pdfFname." for writing.");
	    return(false);
	  }
	  if (!fwrite($lfhandler, $result)) {
	    $this->logDebug("Error writing data to file ".$pdfFname);
	    $this->set_pdf($id,false);
	    return(false);
	  }
	  fclose ($lfhandler);
	  
	  // Update the revision data record.
	  $this->id = $id;
	  $this->set(array(
			   'id'=>$id,
                           'pdf_date' => date('Y-m-d H:i:s'),
			   'has_pdf' => true,
			   ));
	  // And save it
	  if ($this->save()) {
            $this->logDebug("generate_pdf: Updated revision data record");
	    return true;
          }
	  else {
            $this->logDebug("generate_pdf: Failed to save revision data record");
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
	   // create the new revision
	    $this->create(); 
	    $lastrev['Revision']['id']=null;
	    if ($major) {
	       $lastrev['Revision']['major_revision']+=1;
	       $lastrev['Revision']['minor_revision']=1;
            } else {
	       $lastrev['Revision']['minor_revision']+=1;
            }
	    $lastrev['Revision']['doc_status_id']=0;
	    $lastrev['Revision']['doc_status_date']=date('Y-m-d H:i:s');
            // We don't copy the pdf from old revision.
            $lastrev['Revision']['has_pdf']=false;  
	    $this->save($lastrev);
	    $newrev_id = $this->getInsertID();
	    if ($lastrev['Revision']['has_native']) {
	       $folder = $this->get_folder($newrev_id);
	       if (!is_dir($folder)) {
	          $this->logDebug("Attempting to create directory ".$folder);
	       	  if (mkdir($folder,0777,true)) {
	             $this->logDebug("created directory");
		  } else {
		     $this->logDebug("Failed to Create Directory");
		     return false;
		  }
               }
	       // Copy native files
	       copy($this->get_filepath($lastrev_id,'native'),
		    $this->get_filepath($newrev_id,'native'));	       
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
	    $newrev['Revision']['has_pdf']=false;
	    $newrev['Revision']['doc_status_id']=0;
	    $newrev['Revision']['doc_status_date']=date('Y-m-d H:i:s');
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
	$this->set(array('doc_status_id'=>2,
			'doc_status_date'=>date('Y-m-d H:i:s')
			));
	$this->save();
    }

}
