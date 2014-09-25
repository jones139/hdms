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
 * Reports Controller
 *
 * @package       app.Controller
 * @property Doc $Doc
 * @property PaginatorComponent $Paginator
 */
class ReportsController extends AppController {

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
 * index method - Display forms to select the various reports.
 *
 * @param facility - the facility id to filter.
 * @param doc_type - the doc type id to filter.
 * @param doc_subtype - the doc subtype id to filter.
 * @return void
 */
	public function index() {
	}

	/**
	 * recent method - report on recently issued documents - 
	 * date after which documents are considered recent is specified
	 * on a form as a post parameter.
	 */
	public function recent() {
	  $this->loadModel('Revision');
	  if ($this->request->is('post')) {
	    $this->set('date',$this->request->data['Date']);

	    $dateStr = $this->request->data['Date']['date']['year'].'-'.
	      $this->request->data['Date']['date']['month'].'-'.
	      $this->request->data['Date']['date']['day'];
	    $this->set('datestr',$dateStr);
	    $conditions= array(
			       'Revision.doc_status_date >='=>$dateStr,
			       'Revision.doc_status_id'=>2
			       );
	    $data = $this->Revision->find('all',array('conditions'=>$conditions));
	    $this->set('data',$data);

	  }
	}

	/**
	 * drafts function - return list of draft revisions.
	 */
	public function drafts() {
	  $this->loadModel('Revision');
	  
	  $maxRevs = $this->Revision->find('all',array('recursive'=>-1,
						       'fields'=>array('max(doc_id) as doc_id','max(Revision.id) as rev_id'),
		 'group'=>'Revision.doc_id',
							));
	  $data = array();
	  foreach ($maxRevs as $revArr) {
	    $rev = $this->Revision->findById($revArr[0]['rev_id']);
	    if ($rev['Revision']['doc_status_id']=='0' or 
                      $rev['Revision']['doc_status_id']=='1') {
	      $data[] = $rev;
	    }
	  }


	  $this->set('data',$data);
	  $this->set('maxRevs',$maxRevs);
	  
	}

}
