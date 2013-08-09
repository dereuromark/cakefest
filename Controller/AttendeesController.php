<?php
App::uses('AppController', 'Controller');

/**
 * Attendees Controller
 *
 * @property Attendee $Attendee
 * @property PaginatorComponent $Paginator
 */
class AttendeesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public function beforeFilter() {
		parent::beforeFilter();
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Attendee->recursive = 0;
		$attendees = $this->paginate();
		$this->set(compact('attendees'));
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->Attendee->recursive = 0;
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions'=>array('Attendee.id'=>$id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		$this->set(compact('attendee'));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->Common->isPosted()) {
			$this->Attendee->create();
			if ($this->Attendee->save($this->request->data)) {
				$var = $this->request->data['Attendee']['user_id'];
				$this->Common->flashMessage(__('record add %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		}

		$events = $this->Attendee->Event->find('list');
		$users = $this->Attendee->User->find('list');
		$this->set(compact('events', 'users'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions'=>array('Attendee.id'=>$id))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action' => 'index'));
		}
		if ($this->Common->isPosted()) {
			if ($this->Attendee->save($this->request->data)) {
				$var = $this->request->data['Attendee']['user_id'];
				$this->Common->flashMessage(__('record edit %s saved', h($var)), 'success');
				return $this->Common->postRedirect(array('action' => 'index'));
			}
			$this->Common->flashMessage(__('formContainsErrors'), 'error');
		} else {
			$this->request->data = $attendee;
		}
		$events = $this->Attendee->Event->find('list');
		$users = $this->Attendee->User->find('list');
		$this->set(compact('events', 'users'));
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->request->onlyAllow('post', 'delete');
		if (empty($id) || !($attendee = $this->Attendee->find('first', array('conditions'=>array('Attendee.id'=>$id), 'fields'=>array('id', 'user_id'))))) {
			$this->Common->flashMessage(__('invalidRecord'), 'error');
			return $this->Common->autoRedirect(array('action'=>'index'));
		}
		$var = $attendee['Attendee']['user_id'];

		if ($this->Attendee->delete($id)) {
			$this->Common->flashMessage(__('record del %s done', h($var)), 'success');
			return $this->Common->postRedirect(array('action' => 'index'));
		}
		$this->Common->flashMessage(__('record del %s not done exception', h($var)), 'error');
		return $this->Common->autoRedirect(array('action' => 'index'));
	}

}
