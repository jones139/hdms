<?php
App::uses('AppController', 'Controller');
/**
 * Docs Controller
 *
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
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Doc->recursive = 1;
		   $this->Paginator->settings = array(
		   			      'conditions'=>array());
		if (isset($this->params[ 'named' ][ 'facility' ])) {
		   $this->Paginator->settings['conditions']['Doc.facility_id']=
			$this->params[ 'named' ][ 'facility' ];
		} 
		if (isset($this->params[ 'named' ][ 'doc_type' ])) {
		   $this->Paginator->settings['conditions']['Doc.doc_type_id']=
			$this->params[ 'named' ][ 'doc_type' ];
		} 
		if (isset($this->params[ 'named' ][ 'doc_subtype' ])) {
		   $this->Paginator->settings['conditions']['Doc.doc_type_id']=
			$this->params[ 'named' ][ 'doc_subtype' ];
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

		# Now find the issued revision of each document.
		#echo "<pre>".var_dump($docs)."</pre>";
	        #Controller::loadModel('Revisions');
		#foreach ($docs as $doc) {
		#	echo "<pre>".var_dump($doc)."</pre><br/>";
		#}
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
		$this->set(compact('facilities'));
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
		$this->set(compact('facilities'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
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
