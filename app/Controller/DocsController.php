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
		   			      'conditions'=>array());
		if (isset($this->params[ 'named' ][ 'facility' ])) {
		   $facility = $this->params[ 'named' ][ 'facility' ];
		   if ($facility != "All") {
		      $this->Paginator->settings['conditions']['Doc.facility_id']=
			$facility;
		   }
		} 
		if (isset($this->params[ 'named' ][ 'doc_type' ])) {
		   $docType = $this->params[ 'named' ][ 'doc_type' ];
		   if ($docType != "All") {
		      $this->Paginator->settings['conditions']['Doc.doc_type_id']=
			$docType;
		   }
		} 
		if (isset($this->params[ 'named' ][ 'doc_subtype' ])) {
		   $docSubType = $this->params[ 'named' ][ 'doc_subtype' ];
		   if ($docSubType != "All") {
		       $this->Paginator->settings['conditions']['Doc.doc_subtype_id']=
			$docSubType;
                   }
		} 
		if (isset($this->params[ 'named' ][ 'issued' ])) {
	   	      $this->Paginator->settings['contain']=array(
			  'Revision'=>array(
				'order'=> 'Revision.id ASC',
				'limit'=>1
				));
		} 

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
}
