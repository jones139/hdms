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

App::uses('AppController', 'Controller');
/**
 * Docs Controller
 *
 * @package       app.Controller
 * @property Doc $Doc
 * @property PaginatorComponent $Paginator
 */
class DocsController extends AppController {

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
	     $this->Auth->allow(array('index'));

	}

/**
 * index method - the main page displaying document and revision data.
 *  Accepts named parameters facility, doc_type and doc_subtype which 
 *  will filter the results listed to only the relevant documents.
 *
 * @param facility - the facility id to filter.
 * @param doc_type - the doc type id to filter.
 * @param doc_subtype - the doc subtype id to filter.
 * @return void
 */
	public function index() {
		$this->Doc->recursive = 1;
                $this->Paginator->settings = array(
                    'conditions'=>array(),
                    'limit'=>10);

                ################################################
                # Deal with a get query string to filter results.
                if ($this->request->is('get')) {
                    if (isSet($this->request->query['title'])) {
                        $searchStr = $this->request->query['title'];
                        $searchClause =     array(
				'Doc.title LIKE'=> "%$searchStr%",
			    	'Doc.docNo LIKE'=> "%$searchStr%"
				);
                    } else
                        $searchClause = array();

                    if (isSet($this->request->query['Facility'])) 
                        $facArr = $this->request->query['Facility'];
                    else
		      $facArr = array(1,2,3);

                    if (isSet($this->request->query['DocType'])) 
                        $docTypeArr = $this->request->query['DocType'];
                    else
		      $docTypeArr = array(1,2,3,4);

                    if (isSet($this->request->query['DocSubType'])) 
                        $docSubTypeArr = $this->request->query['DocSubType'];
                    else
		      $docSubTypeArr = array(1,2,3,4);

                    # Build the query from the various components.
                    $conditions = array(
                        'AND'=>array(
                            'Doc.Facility_id'=>$facArr,
                            'Doc.Doc_Type_id'=>$docTypeArr,
                            'Doc.Doc_SubType_id'=>$docSubTypeArr
                        ),
                        'OR'=>$searchClause
                        );
                    $this->Paginator->settings['conditions']=$conditions;
                    $this->Paginator->settings['order']=array('docNo'=>'asc');

                    # Send the query to the view so we can populate the
                    # form elements correctly.
                    $this->set('query',$this->request->query);
                }

		$facilities = $this->Doc->Facility->find('list');
		$doc_types = $this->Doc->DocType->find('list');
		$doc_subtypes = $this->Doc->DocSubtype->find('list');
		$this->set(compact('facilities','doc_types','doc_subtypes'));
                
		$docs = $this->Paginator->paginate();
		$this->set('docs', $docs);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Doc->exists($id)) {
			throw new NotFoundException(__('Invalid doc'));
		}
		$options = array('conditions' => array('Doc.' . $this->Doc->primaryKey => $id));
		$this->set('doc', $this->Doc->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
	        if ($this->Auth->user('role_id')!=1) {
 		   $this->Session->setFlash(
                       __('Only an Administrator can add documents!'));
		  return $this->redirect($this->referer()); 
                }
		if ($this->request->is('post')) {
			$this->Doc->create();
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('The doc has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc could not be saved. Please, try again.'));
			}
		}
		$facilities = $this->Doc->Facility->find('list');
		$doc_types = $this->Doc->DocType->find('list');
		$doc_subtypes = $this->Doc->DocSubtype->find('list');
		$this->set(compact('facilities','doc_types','doc_subtypes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
	        $this->Doc->recursive = 2;

		if (!$this->Doc->exists($id)) {
			throw new NotFoundException(__('Invalid doc'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Doc->save($this->request->data)) {
				$this->Session->setFlash(__('The doc has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doc could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Doc.' . $this->Doc->primaryKey => $id));
			$this->request->data = $this->Doc->find('first', $options);
		}
		$facilities = $this->Doc->Facility->find('list');
		$doc_types = $this->Doc->DocType->find('list');
		$doc_subtypes = $this->Doc->DocSubtype->find('list');
		$this->set(compact('facilities','doc_types','doc_subtypes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
	        if ($this->Auth->user('role_id')!=1) {
 		   $this->Session->setFlash(
                       __('Only an Administrator can delete documents!'));
		  return $this->redirect($this->referer()); 
                }
		$this->Doc->id = $id;
		if (!$this->Doc->exists()) {
			throw new NotFoundException(__('Invalid doc'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Doc->delete()) {
			$this->Session->setFlash(__('The doc has been deleted.'));
		} else {
			$this->Session->setFlash(__('The doc could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * home function - displays a pretty home page with selectors
	 * for facilities, doc types and subtypes.
	 */
	public function home() {
	  $this->loadModel('Facilities');
	  $this->loadModel('Doc_types');
	  $this->loadModel('Doc_subtypes');

	  $facilities = $this->Facilities->find('list',array('fields'=>array('title','description')));
	  $docTypes = $this->Doc_types->find('all');
	  $docSubTypes = $this->Doc_subtypes->find('all');

	  $this->set(compact('facilities','docTypes','docSubTypes'));

	}
	
	public function getIssuedRevId($id) {
		$this->autoRender = false;
		$rev_id = $this->Doc->getIssuedRevId($id);
		#echo($rev_id);
	
		return(json_encode($rev_id));
	}
	
/**
 * getIssuedFile method - download file the latest issued version of the document.
 *      By default, returns the pdf version of the file, unless parameter
 *      type is set, in which case it returns the filetype specified by the parameter:
 *       'pdf', 'native' or 'extras'.
 * 
 * @param id - document id of file to download.
 * @param type - 'native','pdf','extras' - defaults to 'pdf' if not specified.
 * @return void
 */
	public function getIssuedFile($id) {
		#Checked for named parameters at the end of the url (e.g. .../Docs/getIssuedFile/8/type:native)
      $filetype = 'pdf';
		if (isset($this->params[ 'named' ][ 'type' ])) {
           if ($this->params['named']['type'] == 'native') {
              $filetype = 'native';
           }
           if ($this->params['named']['type'] == 'extras') {
              $filetype = 'extras';
           }
      }

		# Find the revision Id of the latest issued revision of this document.
		$rev_id = $this->Doc->getIssuedRevId($id);
		echo "rev_id=".$rev_id;

		# then find the filepath to that revision's attached document.
      $filepath = $this->Doc->getIssuedFilepath($id,$filetype);
      if ($filepath) {
			# if the file exists, return it for download.
         $this->response->file(
                $filepath,
                array('download' => true, 'name' => $this->Revision->filename)
         );
         return $this->response;
      } else {
      	# if the file does not exist, show an error.
      	$this->Session->setFlash(__('ERROR - Requested Document Not Found.'));
         return $this->redirect(array('action' => 'home'));
      }
    }
    

}
