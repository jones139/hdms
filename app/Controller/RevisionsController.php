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
 *   Foobar is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with HDMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 ****************************************************************************/
App::uses('AppController', 'Controller');
/**
 * Revisions Controller
 *
 * @package       app.Controller
 * @property Revision $Revision
 * @property PaginatorComponent $Paginator
 */
class RevisionsController extends AppController {
    
/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    
    /**
     * beforeFilter method
     * Set limits on what unauthenticated users can do.
     */
    public function beforeFilter() {
        parent::beforeFilter();
        #$this->Auth->allow('index','view','download_file');
        $this->Auth->allow('index','download_file');    
    }
    

/**
 * index method
 * @param doc_id - return only revisions for document doc_id.
 * @param latest - return only the revisions for the documents (including drafts)
 * @param issued - return only the issuedrevisions
 *
 * @return void
 */
    public function index() {
        $this->Revision->recursive = 0;
        $this->Paginator->settings = array(
            'conditions'=>array(),
            'fields'=>array('*'));		
        if (isset($this->params[ 'named' ][ 'doc_id' ])) {
            $this->Paginator->settings['conditions']['Revision.doc_id'] = 
                $this->params[ 'named' ][ 'doc_id' ];
        } 
        if (isset($this->params[ 'named' ][ 'latest' ])) { #FIXME - this doesn't work!
            $this->Paginator->settings['group']='Revision.doc_id';
            #$this->Paginator->settings['fields'][]='Revision.id';
            $this->Paginator->settings['conditions']['Revision.id']='max(Revision.id)';
        } 
        if (isset($this->params[ 'named' ][ 'issued' ])) {
            #$this->Paginator->settings['group']='Revision.doc_id';
            #$this->Paginator->settings['fields'][]='Revision.id';
            $this->Paginator->settings['conditions']['doc_status_id']=2;
        } 
        
        $this->set('revisions', $this->Paginator->paginate());
    }
    
    
    
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null) {
        if (!$this->Revision->exists($id)) {
            throw new NotFoundException(__('Invalid revision'));
        }
        $options = array('conditions' => array('Revision.' . $this->Revision->primaryKey => $id));
        $this->set('revision', $this->Revision->find('first', $options));
    }
    
/**
 * add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {
            $this->Revision->create();
            if ($this->Revision->save($this->request->data)) {
                $this->Session->setFlash(
                    __('The revision has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __('The revision could not be saved. Please, try again.'));
            }
        }
        $docs = $this->Revision->Doc->find('list');
        $users = $this->Revision->User->find('list');
        $docStatuses = $this->Revision->DocStatus->find('list');
        $this->set(compact('docs', 'users', 'docStatuses'));
    }
    
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($id = null) {
        if (!$this->Revision->exists($id)) {
            throw new NotFoundException(__('Invalid revision'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Revision->save($this->request->data)) {
                $this->Session->setFlash(
                    __('The revision has been saved.'));
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(
                    __('The revision could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array(
                'Revision.' . $this->Revision->primaryKey => $id));
            $this->request->data = $this->Revision->find(
                'first', $options);
        }
        
	#################################	
	# Send the view the list of users
        # Send the view the list of active users (role != 0)
        # NOTE this uses model 'User' not 'Users' - ignores associations
        # if you use 'Users'!!!!!
        $this->loadModel('User');
        $options = array('conditions'=>array('User.role_id != '=>0));
        $usersArr = $this->User->find('all',$options);
        
        # Simplify it to give title as ('Name (position)')
        $users = array();
        foreach ($usersArr as $ua) {
            $users[$ua['User']['id']] = $ua['User']['title'].
            ' ('.$ua['Position']['title'].')';
        }
        
	#################################	
	# Send the view the list of responses
	$this->loadModel('Responses');
	$responses = $this->Responses->find('list');
        
	#################################	
	# Send the view the list of route list statuses
	$this->loadModel('RouteListStatuses');
	$routeListStatuses = $this->RouteListStatuses->find('list');
        
	###########################################################
	# Find the latest route list associated with this revision,
	#  which has not been cancelled (status not equal to 3).
	$this->loadModel('RouteLists');
	$options = array(
            'conditions' => array(
                'revision_id' => $id,
                #   'route_list_status_id !='=>3
            ),
            'order'=>'revision_id asc'
        );
	$routeListArr = $this->RouteLists->find('all',$options);
	$lastRouteList_id = end($routeListArr)['RouteLists']['id'];
	$lastRouteList_status = end($routeListArr)['RouteLists']['route_list_status_id'];
        
	#################################################################
	# Send the view the list of existing route list entries for the 
	#  latest route list
	$this->loadModel('RouteListEntries');
	$options = array('fields'=>array(
            'user_id',
            'response_id',
            'response_date',
            'response_comment'),
        'conditions' => array(
            'route_list_id' => $lastRouteList_id)
        );
	$routeListEntries = $this->RouteListEntries->find('all',$options);
	
	#####################################
	# Actually send the data to the view
	$this->set(compact(
            'users', 
            'responses',
            'routeListStatuses',
            'routeListEntries',
            'routeListArr',
            'lastRouteList_id',
            'lastRouteList_status'
        ));
    }
    
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null) {
        $this->Revision->id = $id;
        if (!$this->Revision->exists()) {
            throw new NotFoundException(__('Invalid revision'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Revision->delete()) {
            $this->Session->setFlash(
                __('The revision has been deleted.'));
        } else {
            $this->Session->setFlash(
                __('The revision could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    
/**
 * attach_file method
 * Upload a native file and attach it to revision number $id.
 *
 * @return void
 */
    public function attach_file($id) {
        # Check the requested revision exists before we get too far.
        $rev = $this->Revision->findById($id);
        if (!$rev) {
            $this->Session->setFlash(
                __('Invalid Revision Number'));           
            return $this->redirect(array('action' => 'edit',$id));
        }

        # If we are trying to upload a native file, but there is already
        # one attaced, tell the user to use checkout/checkin instead.
        if ($rev['Revision']['has_native']) {
            $this->Session->setFlash(
                __('There is already a native file attached - use checkout_file/checkin_file instead.'));           
            return $this->redirect(array('action' => 'edit',$id));
        } 
      
        # If we have submitted a form, process the data, otherwise we
        # display the form.
        if ($this->request->is(array('post','put'))) {
            if ($this->Revision->attach_file(
                $this->request->data,
                $this->Auth->User()
                )) 
                {
                    $this->Session->setFlash(
                        __('File Uploaded.'));
                    return $this->redirect(array(
                        'action' => 'edit',$id));
                } else {
                $this->Session->setFlash(
                    __('File Upload Failed.'));
                return $this->redirect(array('action' => 'edit',$id));
            }
        }
        $options = array('conditions' => array(
            'Revision.' . $this->Revision->primaryKey => $id));
        $this->request->data = $this->Revision->find('first', $options);
}
    
/**
 * attach_pdf method
 * Upload a pdf file and attach it to revision number $id.
 *
 * @return void
 */
    public function attach_pdf($id) {
        # Check the requested revision exists before we get too far.
        $rev = $this->Revision->findById($id);
        if (!$rev) {
            $this->Session->setFlash(
                __('Invalid Revision Number'));           
            return $this->redirect(array('action' => 'edit',$id));
        }

        # If we have submitted a form, process the data, otherwise we
        # display the form.
        if ($this->request->is(array('post','put'))) {
            if ($this->Revision->attach_pdf(
                $this->request->data,
                $this->Auth->User()
                )) 
                {
                    $this->Session->setFlash(
                        __('PDF Uploaded.'));
                    return $this->redirect(array(
                        'action' => 'edit',$id));
                } else {
                $this->Session->setFlash(
                    __('PDF Upload Failed.'));
                return $this->redirect(array('action' => 'edit',$id));
            }
        }
        $options = array('conditions' => array(
            'Revision.' . $this->Revision->primaryKey => $id));
        $this->request->data = $this->Revision->find('first', $options);
}
    
/**
 * attach_extras method
 * Upload an extras .zip file and attach it to revision number $id.
 *
 * @return void
 */
    public function attach_extras($id) {
        # Check the requested revision exists before we get too far.
        $rev = $this->Revision->findById($id);
        if (!$rev) {
            $this->Session->setFlash(
                __('Invalid Revision Number'));           
            return $this->redirect(array('action' => 'edit',$id));
        }

        # If we have submitted a form, process the data, otherwise we
        # display the form.
        if ($this->request->is(array('post','put'))) {
            if ($this->Revision->attach_extras(
                $this->request->data,
                $this->Auth->User()
                )) 
                {
                    $this->Session->setFlash(
                        __('Extras Uploaded.'));
                    return $this->redirect(array(
                        'action' => 'edit',$id));
                } else {
                $this->Session->setFlash(
                    __('Extras Upload Failed.'));
                return $this->redirect(array('action' => 'edit',$id));
            }
        }
        $options = array('conditions' => array(
            'Revision.' . $this->Revision->primaryKey => $id));
        $this->request->data = $this->Revision->find('first', $options);
}
    
    
    
/**
 * check_in_file method
 *
 * @return void
 */
    public function checkin_file($id) {
        if ($this->request->is(array('post','put'))) {
            if ($this->Revision->checkin_file(
                $this->request->data,$this->Auth->User())) {
                $this->Session->setFlash(
                    __('File Checked-In OK.'));
                return $this->redirect(array('action' => 'edit',$id));
            } else {
                $this->Session->setFlash(
                    __('File Check-In Failed.'));
            }
        }
        $options = array('conditions' => array(
            'Revision.' . $this->Revision->primaryKey => $id));
        $this->request->data = $this->Revision->find('first', $options);
    }
    
/**
 * generate_pdf method - use remote web service to generate a PDF version of
 * the native file associated with this revision.
 *
 * @return void
 */
    public function generate_pdf($id) {
            if ($this->Revision->generate_pdf($id)) {
                $this->Session->setFlash(
                    __('Generate PDF Successful'));

            } else {
                $this->Session->setFlash(
                    __('Generate PDF Failed.'));
            }
        $this->redirect(array('action'=>'edit',$id));
        }
    
    
/**
 * checkout_file method:   Marks the file as checked out so that view will
 * present user who checked out the file with a download option.
 *
 * @return void
 */
    public function checkout_file($id) {
        $filepath = $this->Revision->checkout_file($id,$this->Auth->user());
        if ($filepath) {
            $this->Session->setFlash(
                 __('Checkout Successful - Use download link to download file for editing.'));
            #echo "<pre>".$filepath."</pre>";
            #$this->response->file(
            #    $filepath,
            #    array(
            #        'download' => true, 
            #        'name' => $this->Revision->filename)
            #);
            #return $this->response;
        } else {
            $this->Session->setFlash(
                 __('Checkout Failed - Not sure why....sorry....'));
        }
        return $this->redirect(array('action' => 'edit',$id));
    }
    
/**
 * download_file method - download file without checking it out (ie just read-only view).   By default, returns the pdf version of the file, unless parameter
 * native is set, in which case it returns the native file.
 * 
 * @param id - revision id of file to download.
 * @param type - 'native','pdf','extras' - defaults to 'pdf' if not specified.
 * @return void
 */
    public function download_file($id) {
        $filetype = 'pdf';
        if (isset($this->params[ 'named' ][ 'type' ])) {
           if ($this->params['named']['type'] == 'native') {
              $filetype = 'native';
           }
           if ($this->params['named']['type'] == 'extras') {
              $filetype = 'extras';
           }
        }
        $filepath = $this->Revision->get_filepath($id,$filetype);
        if ($filepath) {
            #echo "<pre>filetype=".$filetype.", path=".$filepath."</pre>";
            $this->response->file(
                $filepath,
                array('download' => true, 'name' => $this->Revision->filename)
            );
            return $this->response;
        } else {
            return $this->redirect(array('action' => 'edit',$id));
        }
    }
    
    
    
/**
 * cancel_checkout_file method:   Cancel the check-out - will also
 * Only works for administrator or the user who checked out the file.
 *
 * @return void
 */
    public function cancel_checkout_file($id) {
        if (!$this->Revision->exists($id)) {
            throw new NotFoundException(__('Invalid revision'));
        }
        $rev = $this->Revision->findById($id);
        if ($rev['Revision']['check_out_user_id']!=$this->Auth->User('id')
              and $this->Auth->user('role_id')!=1) {
           $this->Session->setFlash(
                 __('You can not cancel someone else\'s check out unless you are an Administrator!'));
                 return $this->redirect(array('action' => 'edit',$id));
        }

        # To get here we must be allowed to cancel the check-out, so do it.
        $this->Revision->cancel_checkout_file($id);
           $this->Session->setFlash(
                 __('Check out cancelled'));
        return $this->redirect(array('action' => 'edit',$id));
    }
    
    
/**
 * create_new_revision
 *   create a new revision of document id $docid
 *   if named parameter 'major' is set a major revision is created,
 *     otherwise a minor revision is created.
 */
    public function create_new_revision($docid) {
        $major_rev = false;
        if (isset($this->params[ 'named' ][ 'major' ])) {
            $major_rev = true;
        } 
        $new_id = $this->Revision->create_new_revision($docid,$major_rev);
        return $this->redirect(array('action' => 'edit',$new_id));
    }	    

} # End of class definition.
